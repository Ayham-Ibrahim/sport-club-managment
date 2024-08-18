<?php 
namespace App\Services;

use App\Http\Traits\FileStorageTrait;
use Exception;
use App\Models\Sport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;

class SportService {

    use ApiResponseTrait,FileStorageTrait;
    /**
     * list all receiving points
     */
    public function listsports() {
        try {
            return Sport::all();
        } catch (Exception $e) {
            Log::error('Error Listing sports '. $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Create a new Sport
     * @param array $data
     * @return \App\Models\Sport
     */
    public function createSport(array $data){
        try {
            DB::beginTransaction();
                // Create a new sport record with the provided data
                $sport = Sport::create([
                    'name'         => $data['name'],
                    'description'  => $data['description'],
                    "price_per_month"=> $data['price_per_month'],
                ]);
                // Assuming request->images is an array of image paths/files
                $this->storeAndAssociateImages($sport, $data['images'], 'sport_images');
                // Assuming request->videos is an array of video paths/files
                $this->storeAndAssociateVideos($sport, $data['videos'], 'sport_videos');
            DB::commit();
            return $sport;
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error creating sport.: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }


    /**
     * Update a specific sport.
     *
     * @param array $data
     * @param Sport $sport
     * @return \App\Models\Sport
     */
    public function updateSport(array $data,$sport) {
        try {
            DB::beginTransaction();
                // Update the sport with the provided data
                $sport->name = $data['name'] ?? $sport->name;
                $sport->description = $data['description'] ?? $sport->description;
                $sport->price_per_month = $data['price_per_month'] ?? $sport->price_per_month;
                $this->updateAndAssociateNewImages($sport,$data['images'], 'sport_images');
                $this->updateAndAssociateNewVideos($sport,$data['videos'], 'sport_videos');
                $sport->save();
            DB::commit();
            // Return the updated sport
            return $sport;
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error updating sport: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }


    
    /**
     * Delete a specific sport by its ID.
     *
     * @param sport $sport
     * @param Sport $sport
     * @return void
     */
    public function deleteSport($sport){
        try {
            $sport->delete();
        } catch (Exception $e) {
            Log::error('Error deleting sport '. $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }
}