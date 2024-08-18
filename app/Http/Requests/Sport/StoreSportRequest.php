<?php

namespace App\Http\Requests\Sport;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreSportRequest extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'            => 'required|string|min:2',       
            'description'     => 'required|string|min:2', 
            'price_per_month' => 'required|numeric|min:0.01',   
            'images.*'        => 'required|file|image|mimes:png,jpg,jpeg,jfif|max:10000|mimetypes:image/jpeg,image/png,image/jpg,image/jfif', // Validate each image individually
            'images'          => 'array',
            'videos.*'        => 'required|file|mimes:mp4,avi,mpeg,mov,mkv|max:50000|mimetypes:video/mp4,video/x-msvideo,video/mpeg,video/quicktime,video/x-matroska', // Validate each video individually
            'videos'          => 'array',
        ];
    }

      /**
     *  method handles failure of Validation and return message
     * @param \Illuminate\Contracts\Validation\Validator $Validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    protected function failedValidation(Validator $Validator){
        $errors = $Validator->errors()->all();
        throw new HttpResponseException($this->errorResponse($errors,'Validation error',422));
    }
}
