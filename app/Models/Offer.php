<?php

namespace App\Models;

use App\Models\Sport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'description',
        'discount_percentage',
        'valid_from',
        'valid_to',
        'sport_id',
    ];

    /**
     * the sport that the offer belong to it
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
