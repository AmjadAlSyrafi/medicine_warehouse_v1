<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineRequest extends FormRequest
{
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
            'scientificName' => ['required','string'],
            'tradeName' => ['required','string'],
            'classificationId' =>['required','integer'],
            'companyNameId' => ['required','integer'],
            'availableQuantity' => ['required','integer'],
            'expiryDate' => ['required','date'],
            'price' => ['required','numeric'],
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'scientific_name'=> $this->scientificName ,
            'trade_name'=> $this->tradeName ,
            'expiry_date'=> $this->expiryDate ,
            'company_name_id'=> $this->CompanyNameId ,
            'available_quantity'=> $this->availableQuantity ,
            'classification_id' => $this->classificationId,
            ]);
    }
}
