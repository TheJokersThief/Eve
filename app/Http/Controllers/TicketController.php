<?php

namespace App\Http\Controllers;

use Request;
use Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Ticket;
use App\Event;
use App\User;
use Auth;
use DateTime;
use Crypt;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Eluceo\iCal;
use Eluceo\iCal\Component\Calendar;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error;

class TicketController extends Controller
{

	private $errorMessages = [
		'event_not_found' => 'We can\'t find the event that you requested.',
		'ticket_exists' => "It appears you already have a ticket",
		'card_declined' => "Your card has been declined.",
		'server_error' => "We're having some issues with our server. Try again later.",
		'dev_mistake' => "It seems the developers have made a mistake; they have been notified. This will be fixed.",
		'dev_mistake_auth' => "It seems the developers have made a mistake with authentication; this will be fixed.",
		'network_error' => "We're having some network errors right now. Try again later.",
		'something_wrong' => "Something went wrong here.",
		'ticket_invalid' => 'Ticket is invalid',
		'not_logged_in' => 'Are you logged in?',
		'ticket_not_found' => "Not found!"
	];

	/**
	 * Return a printable view of the ticket
	 * @param  Integer  $eventId    ID of the ticket to be printed
	 * @return View                 Printable ticket view
	 */
	public function printable($ticketId){
		$ticketId =  Crypt::decrypt($ticketId);

		$ticket = Ticket::where('user_id', Auth::user()->id)
						->where('id', $ticketId)
						->firstOrFail();

		return view( 'tickets.print', compact('ticket') );
	}

	/**
	 * Return a printable view of the ticket
	 * @param  Integer  $eventId    ID of the ticket to be printed
	 * @return View                 Printable ticket view
	 */
	public function printableNameTag($ticketId){
		$ticket = Ticket::findOrFail($ticketId);

		return view( 'tickets.nametag', compact('ticket') );
	}


	/**
	 * Return a printable view of the ticket
	 * @param  Integer  $eventId    ID of the ticket to be printed
	 * @return View                 Printable ticket view
	 */
	public function printable($eventId){
		$ticket = Ticket::where('user_id', Auth::user()->id)
						->where('event_id', $eventId)
						->firstOrFail();
		$event = $ticket->event;

		return view( 'tickets.print', compact('ticket') );
	}

	/**
	 * Return a representation of a ticket.
	 * @param  Integer 	$eventId 	ID of the event to view
	 * @return View          		Ticket View
	 */
	public function show($eventId){
		if( !is_numeric( $eventId ) ){
			$eventId = Crypt::decrypt( $eventId );
		}

		$ticket = Ticket::where('user_id', Auth::user()->id)
						->where('event_id', $eventId)
						->firstOrFail();
		$event = $ticket->event;

		return view('tickets.show', compact('ticket', 'event'));
	}


	/**
	 * Creates a ticket for the event for the logged-in user, or if the user
	 * already has a ticket, return theirs.
	 *
	 * @param  Integer 	$eventId 	ID of the event for the ticket.
	 * @return View 		        Ticket View
	 */
	public function store(){
		$data = Request::only( [
			"event_id",
			"stripeToken"
		] );

		try{
			$event = Event::findOrFail($data["event_id"]);
		} catch (ModelNotFoundException $e) {
			return Redirect::back()->withErrors([
				'message' => $this->errorMessages['event_not_found']
			]);
		}

		$user  = Auth::user();
		if(Ticket::where('event_id', $event->id)->where('user_id', $user->id)->get()->toArray()){
			return Redirect::back()->withErrors([
				"message" => $this->errorMessages['ticket_exists']
			]);
		}


		if($event->price > 0){
			// If the ticket ain't free you're going to have to pay for it.
			// Let's Stripe.
			Stripe::setApiKey(env('STRIPE_SECRET'));

			try{

				// Create a reference for a Customer relating to the Stripe token we received
				$customer = Customer::create([
					"email" => $user->email,
					"card" => $data["stripeToken"]
				]);

				// Now, charge that customer for the ticket as expected.
				$charge = Charge::create([
					"customer" => $customer->id,
					"amount" => $event->price*100,
					"currency" => "eur"
				]);
			} catch(Error\Card $e) {
				return Redirect::back()->withErrors([
					// Card declined.
					"message" => $this->errorMessages['card_declined']
				]);
			} catch (Error\RateLimit $e) {
				return \Redirect::back()->withErrors([
					// Stripe API limit reached (This should NOT happen!)
					"message" => $this->errorMessages['server_error']
				]);
			} catch (Error\InvalidRequest $e) {
				dd($e);
				return Redirect::back()->withErrors([
					// We're not doing Stripe right. We need to fix this.
					"message" => $this->errorMessages['dev_mistake']
				]);
			} catch (Error\Authentication $e) {
				return Redirect::back()->withErrors([
					// API keys wrong?
					"message" => $this->errorMessages['dev_mistake_auth']
				]);
			} catch (Error\ApiConnection $e) {
				return Redirect::back()->withErrors([
					// Network connectivity problems?
					"message" => $this->errorMessages['network_error']
				]);
			} catch (Error\Base $e) {

				// I actually don't know what this error means
				// or what it does, so probably panic

				return Redirect::back()->withErrors([
					"message" => $this->errorMessages['something_wrong']
				]);
			}
			$ticket = Ticket::create(
				[
					"user_id"  => $user->id,
					"event_id" => $event->id,
					"price" => $event->price,
					"used" => false,
					"printed" => false,
					"charge_id" => $charge->id //Reference to transaction details in Stripe
				]
			);
		} else {
			$ticket = Ticket::create(
				[
					"user_id"  => $user->id,
					"event_id" => $event->id,
					"price" => $event->price,
					"used" => false,
					"printed" => false,
					"charge_id" => null // No charge made
				]
			);
		}

		MailController::sendTicket( $ticket );
		return Redirect::back()->with('message', "You've got a ticket! Find your details and print it out here.");
	}

	/**
	 * Admin function to validate a ticket and return the user's
	 * name badge.
	 *
	 * @param  String 	$code 	QR code value of the ticket.
	 * @return View       		Name badge for the user corresponding to the ticket.
	 */
	public function verify($code){
		if( Auth::user()->is_staff || Auth::user()->is_admin ){
			try{
			  $ticket = Ticket::hasCode($code)->firstOrFail();
			} catch (ModelNotFoundException $e) {
				return view("tickets.unverifiable", ['error' => $this->errorMessages['ticket_invalid']]);
			}
			if( $ticket->used ){
				return view("tickets.unverifiable", ['error' => 'Ticket already used.']);
			} else {
				$ticket->used = true;
				$ticket->scanned_by = Auth::user()->id;
				$ticket->save();

				// Return name badge for printing.
				return view("tickets.verified", ['ticket' => $ticket]);
			}
		} else {
			// user is admin, cannot validate tickets.
			return view("tickets.unverifiable", ['error' => $this->errorMessages['not_logged_in']]);
		}
	}

	public function markPrinted($ticketId){
		if(Auth::check() && Auth::user()->is_staff){
			try{
				$ticket = Ticket::findOrFail($ticketId);
			} catch (ModelNotFoundException $e){
				return ["success" => false, "message" => $this->errorMessages['ticket_not_found']];
			}
			$ticket->printed = true;
			$ticket->save();
			return ["success" => true, "message" => "Ticket marked as printed!"];
		} else {
			return ["success" => false, "message" => $this->errorMessages['not_logged_in']];
		}
	}

	/**
	 * @return A JSON respnose with a list of all the tickets
	 * scanned by this authenticated user, that haven't been marked done
	 */
	public function ticketsToPrint(){
		return Ticket::where('scanned_by', Auth::user()->id)
					 ->where('printed', false)
			         ->get();
	}

	/**
	 * Generates and returns an iCal file for a ticket.
	 * @param  String $code  Code of a ticket in the system.
	 * @return .ics file     iCal file representing that ticket.
	 */
	public function iCal($code){
		$vCalendar = new Calendar( $_SERVER["HTTP_HOST"] );

		try{
		  $ticket = Ticket::hasCode($code)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return view("tickets.unverifiable", ['error' => $this->errorMessages['ticket_invalid']]);
		}

		$event = $ticket->event;

		// Have to call Event this way to avoid clash with App\Event
		$vEvent = new iCal\Component\Event();

		$breakAddress = explode(",", $event->location->name, 2);
		$firstName = $breakAddress[0];


		$vEvent->setDtStart(new DateTime($event->start_datetime))
			   ->setDtEnd(new DateTime($event->end_datetime))
			   ->setLocation($event->location->name, $firstName, "{$event->location->latitude}, {$event->location->longitude}")
			   ->setSummary($event->title);


		$vCalendar->addComponent($vEvent);
		header('Content-Type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="cal.ics"');
		echo $vCalendar->render();
	}
}
