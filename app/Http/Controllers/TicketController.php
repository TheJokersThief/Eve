<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\Event;
use App\User;
use Auth;
use DateTime;
use Crypt;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Eluceo\iCal;
use Eluceo\iCal\Component\Calendar;

class TicketController extends Controller
{
	/**
	 * Return a representation of a ticket.
	 * @param  Integer 	$eventId 	ID of the event to view
	 * @return View          		Ticket View
	 */
	public function show($eventId){
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
		$data = Request::only( ["event_id"] );
		try{
			$event = Event::findOrFail($data["event_id"]);
		} catch (ModelNotFoundException $e) {
			Redirect::back()->withErrors([
				'message' => 'We can\'t find the event that you requested.'
				]);
		}
		$user  = Auth::user();

		$ticket = Ticket::firstOrCreate(
						[
							"user_id"  => $user->id,
							"event_id" => $event->id
						]
					);

		return $this->show($ticket->id);
		// return view('tickets.show', $ticket);
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
				return view("tickets.unverifiable", ['error' => 'Ticket code invalid.']);
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
			return view("tickets.unverifiable", ['error' => 'You are not allowed to verify tickets; are you logged in?']);
		}
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
			return view("tickets.unverifiable", ['error' => 'Ticket code invalid.']);
		}

		$event = $ticket->event;

		// Have to call Event this way to avoid clash with App\Event
		$vEvent = new iCal\Component\Event();

		$breakAddress = explode(",", $event->location->name, 2);
		$firstName = $breakAddress[0];


		$vEvent->setDtStart(new DateTime($event->start_datetime))
			   ->setDtEnd(new DateTime($event->end_datetime))
			   ->setLocation($event->location->name, $firstName, $event->location->coordinates)
			   ->setSummary($event->title);


		$vCalendar->addComponent($vEvent);
		header('Content-Type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="cal.ics"');
		echo $vCalendar->render();
	}
}
