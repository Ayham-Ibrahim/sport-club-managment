<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        DB::beginTransaction();
        // Fetch the subscription associated with the payment
        $subscription = Subscription::find($payment->subscription_id);
        // Check if the subscription exists
        if ($subscription) {
            // Update the subscription status to active
            $subscription->status = 'active';
            $subscription->save();
        }

        // prepare message for email
        $data['email'] = $subscription->email;
        $data['body']  = " لقد قمت بعملية دفع بقيمة {$payment->amount}  .... الان تم تفعيل اشتراككم ";
        // send mail to user
        Mail::send('emails.activateEmail', ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['body']);
        });
        DB::commit();
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
