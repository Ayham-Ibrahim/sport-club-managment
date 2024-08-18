<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Sport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'sport_id',
    ];


    /**
     *  the sport that faciliry belongs to it
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Facility rooms
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
