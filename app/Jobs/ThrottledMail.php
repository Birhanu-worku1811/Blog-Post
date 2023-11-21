<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Redis\LimiterTimeoutException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class ThrottledMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $user;
    public $mail;

    /**
     * Create a new job instance.
     */
    public function __construct(Mailable $mail, User $user)
    {
        $this->mail = $mail;
        $this->user = $user;
    }

    /**
     * Execute the job.
     * @throws LimiterTimeoutException
     */
    public function handle(): void
    {
        Redis::throttle('mailtrap')->allow(10)->every(60)->then(function () {
            Mail::to($this->user)->send($this->mail);
        }, function () {
            return $this->release(5);
        });
    }
}
