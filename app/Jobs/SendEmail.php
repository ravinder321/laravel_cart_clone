<?php 

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendMail;


class SendEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $data;

    public function __construct($data)
    {
        $this->data = $data; // Correctly assign the data 
    }
 


    /**
     * Execute the job.
     */
    public function handle()
    {
        // Send email to the email address provided in $this->data
        Mail::to($this->data)->send(new SendMail($this->data));
    }
}