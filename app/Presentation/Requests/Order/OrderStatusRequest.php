<?php

namespace App\Presentation\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required|string|in:pending,approved,rejected,canceled',
        ];
    }
}
