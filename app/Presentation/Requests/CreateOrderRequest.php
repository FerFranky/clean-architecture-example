<?php

namespace App\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
        ];
    }
}
