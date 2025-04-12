<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép tất cả request (có thể điều chỉnh tùy theo logic xác thực)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên group không được để trống',
            'name.max' => 'Tên group không được vượt quá :max ký tự',
            'user_ids.array' => 'Danh sách user không hợp lệ',
            'user_ids.*.exists' => 'user được chọn không tồn tại',
        ];
    }
}
