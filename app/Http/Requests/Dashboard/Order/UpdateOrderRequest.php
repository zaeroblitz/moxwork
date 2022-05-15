<?php

namespace App\Http\Requests\Dashboard\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'buyer_id' => [
                'nullable', 'integer'
            ],
            'freelancer_id' => [
                'nullable', 'integer'
            ],
            'service_id' => [
                'nullable', 'integer'
            ],
            'file' => [
                'required', 'mimes:zip', 'max:10240'
            ],
            'note' => [
                'required', 'string', 'max:10000'
            ],
            'expired' => [
                'nullable', 'date'
            ],
            'order_status_id' => [
                'nullable', 'integer'
            ],
        ];
    }
}