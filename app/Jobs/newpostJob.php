<?php

namespace App\Jobs;

use App\Mail\newPostMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class newpostJob implements ShouldQueue
{
    use Dispatchable, SerializesModels,InteractsWithQueue,Queueable;

    public $post;
    public $emailPost;
    public function __construct($post,$emailPost)
    {
        $this->post = $post;
        $this->emailPost = $emailPost;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->emailPost as $email)
        {
            Mail::to($email->user->email)->send(new newPostMail($this->post));
        }
    }
}
