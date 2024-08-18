<?php

namespace App\Models;

use App\Models\Sport;
use App\Models\Facility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'name',
        'sport_id',
        'days_available',
    ];


    protected $casts = [
        'days_available' => 'array', // Automatically cast JSON to array
    ];

    /**
     *  the sport that rooms belong to it
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * the facility that rooms belong to it
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
