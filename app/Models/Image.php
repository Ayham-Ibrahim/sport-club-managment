<?php

namespace App\Models;

use App\Models\Sport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = ['sport_id', 'path', 'size'];

    /**
     * get sport that own th images
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
