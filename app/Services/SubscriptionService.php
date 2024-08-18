<?php 
namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\Offer;
use App\Models\Sport;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\ApiResponseTrait;


class SubscriptionService {

    use ApiResponseTrait;
    /**
     *  createSubscription
     * @param array $data
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function createSubscription(array $data) {
        DB::beginTransaction();
        try {
             // Ensure 'months' is treated as an integer
            $months = (int) $data['months'];
            //total price for all subscription months
            $sport = Sport::findOrFail($data['sport_id']);
            $startDate = now();
            $endDate = $startDate->copy()->addMonths($months);
            $totalAmount = $sport->price * $months;

            // Create the subscription
            $subscription = Subscription::create([
                'name' => $data['name'],
                'email' =>  $data['email'],
                'sport_id' =>  $data['sport_id'],
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);


            // prepare message for email
            $data['email'] = $subscription->email;
            $data['body']  = "أهلا بكم في نادينا ... نرجو منكم اجراء عملية الدفع حتى بتفعل اشتراككم";
             // send mail to user
            Mail::send('emails.notification', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['body']);
            });

            DB::commit();
            return $subscription;
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }


    
    /**
     * Update a specific subscription.
     *
     * @param array $data
     * @param Subscription $subscription
     * 
     */
    public function renewSubscription(array $data,$subscription) {
        try {
            $months = (int) $data['months'];
            $sport = Sport::findOrFail($subscription->sport_id);
            $discount = 0;

            // Calculate the new end date and total amount
            $subscription->end_date = Carbon::parse($subscription->end_date)->addMonths($months);
            $totalAmount = $sport->price * $months;

            // Apply any active discounts
            $offer = Offer::where('sport_id', $subscription->sport_id)
                        ->where('valid_from', '<=', Carbon::now())
                        ->where('valid_to', '>=', Carbon::now())
                        ->first();
            
            if ($offer) {
                $discount = $offer->discount_percentage;
                $totalAmount = $totalAmount - ($totalAmount * ($discount / 100));
            }

            // Save the updated subscription and payment
            $subscription->save();
            return [$subscription,$discount];
        } catch (Exception $e) {
            Log::error('Error updating Subscription: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }
}