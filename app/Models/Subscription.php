<?php

namespace App\Models;

use App\Models\Sport;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'sport_id',
        'start_date',
        'end_date',
        'status',
        'reason_of_suspension',
    ];

    /**
     * return the sport that the subscriper apply to it
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * the payments of subscriper
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
