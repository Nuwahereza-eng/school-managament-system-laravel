<?php

namespace App\Http\Requests;

use App\Models\Teacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherAddUpdateRequest extends FormRequest
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
        $teacherId = $this->route('id');
        
        $rules = [
            'first_name' => 'required|string|max:30|regex:/^[a-zA-Z\s]+$/',
            'surname' => 'required|string|max:30|regex:/^[a-zA-Z\s]+$/',
            'birth_date' => 'required|date|before:today',
            'email' => [
                'required',
                'email',
                Rule::unique('teachers', 'email')->ignore($teacherId),
            ],
            'phone_number' => 'required|regex:/^(\+?256|0)?[\s]?[37][0-9]{1,2}[\s]?[0-9]{3}[\s]?[0-9]{3}$/',
            'address' => 'required|string|max:255',
            'gender' => 'required|boolean',
            'status' => ['nullable', Rule::in(array_keys(Teacher::getStatusOptions()))],
            'hire_date' => 'nullable|date',
            'qualification' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:100',
        ];

        // Photo validation - required for new teachers, optional for updates
        if ($teacherId) {
            $rules['photo'] = 'nullable|mimes:jpeg,bmp,png,jpg|max:2048';
        } else {
            $rules['photo'] = 'required|mimes:jpeg,bmp,png,jpg|max:2048';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'First name should only contain letters and spaces.',
            'surname.required' => 'Surname is required.',
            'surname.regex' => 'Surname should only contain letters and spaces.',
            'birth_date.required' => 'Birth date is required.',
            'birth_date.before' => 'Birth date must be before today.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex' => 'Please enter a valid Ugandan phone number.',
            'photo.required' => 'Teacher photo is required.',
            'photo.mimes' => 'Photo must be a JPEG, BMP, PNG, or JPG file.',
            'photo.max' => 'Photo size must not exceed 2MB.',
            'address.required' => 'Address is required.',
            'status.in' => 'Invalid status selected.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name' => 'first name',
            'surname' => 'surname',
            'birth_date' => 'date of birth',
            'phone_number' => 'phone number',
            'hire_date' => 'hire date',
        ];
    }
}
