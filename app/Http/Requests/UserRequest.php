<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'group_ids' => 'nullable|array',
            'group_ids.*' => 'exists:groups,id',
        ];

        // Khi tạo mới user, yêu cầu password
        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }
        // Khi cập nhật user, password là tùy chọn
        else if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
            $rules['email'][] = Rule::unique('users')->ignore($this->route('user'));
        }

        // Khi tạo mới, email phải là duy nhất
        if ($this->isMethod('post')) {
            $rules['email'][] = 'unique:users';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên user không được để trống',
            'name.max' => 'Tên user không được vượt quá :max ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'group_ids.array' => 'Danh sách group không hợp lệ',
            'group_ids.*.exists' => 'group được chọn không tồn tại',
        ];
    }
}
