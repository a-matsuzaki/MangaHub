<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditVolumeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'note' => 'nullable|string|max:1000',
            'is_owned' => 'required|in:0,1',
            'is_read' => 'required|in:0,1',
            'wants_to_buy' => 'required|in:0,1',
            'wants_to_read' => 'required|in:0,1',
        ];
    }
}
