<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentAddUpdateRequest extends FormRequest
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
        $rules = [
            'first_name' => 'required|string|max:30|regex:/^[a-zA-Z\s]+$/',
            'surname' => 'required|string|max:30|regex:/^[a-zA-Z\s]+$/',
            'birth_date' => 'required|date|before:today',
            'classroom' => ['required', Rule::exists('classrooms', 'id')],
            // Accepts: 0771234567, +256771234567, +256 771 234 567, 256771234567
            'parent_phone_number' => 'required|regex:/^(\+?256|0)?[\s]?[37][0-9]{1,2}[\s]?[0-9]{3}[\s]?[0-9]{3}$/',
            'second_phone_number' => 'nullable|regex:/^(\+?256|0)?[\s]?[37][0-9]{1,2}[\s]?[0-9]{3}[\s]?[0-9]{3}$/',
            'address' => 'required|string|max:255',
            'gender' => 'required|boolean',
            'status' => ['nullable', Rule::in(array_keys(Student::getStatusOptions()))],
            'notes' => 'nullable|string|max:1000',
        ];

        // Enrollment date validation - different for create vs update
        if ($this->has('id') || $this->route('id')) {
            $rules['enrollment_date'] = 'required|date';
        } else {
            $rules['enrollment_date'] = 'required|date|after_or_equal:today';
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
            'classroom.required' => 'Please select a classroom.',
            'classroom.exists' => 'The selected classroom is invalid.',
            'parent_phone_number.required' => 'Parent phone number is required.',
            'parent_phone_number.regex' => 'Please enter a valid Ugandan phone number.',
            'second_phone_number.regex' => 'Please enter a valid Ugandan phone number.',
            'address.required' => 'Address is required.',
            'enrollment_date.required' => 'Enrollment date is required.',
            'enrollment_date.after_or_equal' => 'Enrollment date must be today or a future date.',
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
            'classroom' => 'classroom',
            'parent_phone_number' => 'parent phone number',
            'second_phone_number' => 'secondary phone number',
            'enrollment_date' => 'enrollment date',
        ];
    }
}
