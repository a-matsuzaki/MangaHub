<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditSeriesRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'start_volume_add' => 'nullable|integer|min:1',
            'end_volume_add' => 'nullable|integer|min:1|gte:start_volume_add',
            'start_volume_remove' => 'nullable|integer|min:1',
            'end_volume_remove' => 'nullable|integer|min:1|gte:start_volume_remove',
            'author' => 'nullable|string|max:255',
            'publication' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'start_volume_add' => $this->input('start_volume_add')
                ? (int)mb_convert_kana($this->input('start_volume_add'), 'n')
                : null,
            'end_volume_add' => $this->input('end_volume_add')
                ? (int)mb_convert_kana($this->input('end_volume_add'), 'n')
                : ($this->input('start_volume_add') ? (int)mb_convert_kana($this->input('start_volume_add'), 'n') : null),
            'start_volume_remove' => $this->input('start_volume_remove')
                ? (int)mb_convert_kana($this->input('start_volume_remove'), 'n')
                : null,
            'end_volume_remove' => $this->input('end_volume_remove')
                ? (int)mb_convert_kana($this->input('end_volume_remove'), 'n')
                : ($this->input('start_volume_remove') ? (int)mb_convert_kana($this->input('start_volume_remove'), 'n') : null),
        ]);
    }
}
