<?php

namespace App\Presentation\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
        ];
    }
}
