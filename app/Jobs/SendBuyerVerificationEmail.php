<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Buyer;
use App\Notifications\BuyerVerifyEmailNotification;

class SendBuyerVerificationEmail implements ShouldQueue
{
    use Queueable, Dispatchable;

    protected Buyer $buyer;

    /**
     * Create a new job instance.
     */
    public function __construct(Buyer $buyer)
    {
        $this->buyer=$buyer;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->buyer->notify(new BuyerVerifyEmailNotification());
    }
}
