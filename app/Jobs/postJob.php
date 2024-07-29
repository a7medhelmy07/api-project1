<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\postMail;
use Illuminate\Support\Facades\Mail;



class postJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $posts;
    public $email;
    public function __construct($posts , $email)
    {
        $this->posts = $posts;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->email as $email) {
            Mail::to($email)->send(new postMail($this->posts));
            sleep(1);
            }
}
}
