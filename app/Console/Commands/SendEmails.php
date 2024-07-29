<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\PostMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to users';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $post = Post::latest()->first();
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new PostMail($post));
            $this->info('Email sent to ' . $user->email);
        }

        $this->info('Emails have been sent successfully!');
    }
}
