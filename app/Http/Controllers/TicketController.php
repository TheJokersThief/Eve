<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\Event;
use App\User;
use Auth;
use Crypt;

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

        return $ticket->qr();
        // return view('tickets.show', $ticket);
    }

    /**
     * Creates a ticket for the event for the logged-in user, or if the user
     * already has a ticket, return theirs.
     * 
     * @param  Integer 	$eventId 	ID of the event for the ticket.
     * @return View 		        Ticket View
     */
    public function store($eventId){
    	$event = Event::firstOrFail($eventId);
    	$user  = Auth::user();

    	$ticket = Ticket::firstOrCreate(
    					[
    						"user_id"  => $user->id,
    						"event_id" => $event->id
    					]
    				);

    	return $ticket;
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
	    	$ticket = Ticket::hasCode($code)->firstOrFail();
	    	if( $ticket->used ){
	    		return "Ticket used!";
	    	} else {
	    		$ticket->used = true;
	    		$ticket->save();

	    		// Return name badge for printing.
	    		return "Ticket Verified!";
	    	}
    	} else {
    		// user is admin, cannot validate tickets.
    	}
    }
}
