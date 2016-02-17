<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use Mail;

use App\User;
use App\Event;
use App\Ticket;
use App\Setting;

class SendEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $user;
    private $event;
    private $ticket;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
    	$this->user = $ticket->user;
    	$this->event = $ticket->event;
    	$this->ticket = $ticket;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    	$data['user'] = $this->user;
    	$data['event'] = $this->event;
    	$data['ticket'] = $this->ticket;
    	$data['company_logo'] = Setting::where('name', 'company_logo')->first()->setting;
    	$data['company_name'] = Setting::where('name', 'company_name')->first()->setting;

    	Mail::send('emails.ticket', $data, function ($message) use ( $data ){
		    $message->from("no-reply@" . str_replace('http://', '', \URL::to('/')), $data['company_name']);

		    $message->to( $data['user']->email );
		});
    }
}
