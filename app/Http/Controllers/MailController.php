<?php namespace App\Http\Controllers;

use View;
use Auth;
use Response;
use Redirect;
use Request;
use Validator;
use Crypt;
use DB;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Bus;

use App\Ticket;

class MailController extends Controller
{

	public function index( ){
		$this->sendTicket( Ticket::find(1) );
	}

	public static function sendTicket( Ticket $ticket ){
		Bus::dispatch( new SendEmail( $ticket ) );
	}

}
