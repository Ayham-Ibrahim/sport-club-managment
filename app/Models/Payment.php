<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'subscription_id',
        'amount',
        'payment_date',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

        /**
     * The "booted" method of the model.
     *
     * Automatically set the payment_date to now when creating a new payment.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($payment) {
            $payment->payment_date = Carbon::now(); // Set payment_date to current time
        });
    }
}
