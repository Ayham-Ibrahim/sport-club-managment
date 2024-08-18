<?php

namespace App\Models;

use Exception;
use App\Models\Room;
use App\Models\Image;
use App\Models\Offer;
use App\Models\Video;
use App\Models\Facility;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sport extends Model
{
    use HasFactory;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price_per_month',
    ];

    // Automatically eager load images and videos
    protected $with = ['images','videos'];


    /**
     * facilities that belongs to the sport
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    /**
     *  rooms that belongs to the sport
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     *  subscriptions that belongs to the sport
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     *  offers that belongs to the sport
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * get sport's images
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * get sport's videos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

     /**
     * Delete the hotel and its associated images.
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($sport) {
            DB::beginTransaction();
            $sport->images()->each(function ($image) {
                try {
                    // Attempt to delete the file from the filesystem
                    $filePath = public_path($image->path);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                } catch (Exception $e) {
                    Log::error("Error deleting file: {$e->getMessage()}");
                }
                // we can make delete for soft delete
                $image->forceDelete();
            });
            $sport->videos()->each(function ($video) {
                try {
                    // Attempt to delete the file from the filesystem
                    $filePath = public_path($video->path);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                } catch (Exception $e) {
                    Log::error("Error deleting file: {$e->getMessage()}");
                }
                // we can make delete for soft delete
                $video->forceDelete();
            });
            DB::commit();
        });
    }
}
