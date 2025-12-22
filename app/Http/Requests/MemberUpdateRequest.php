<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // For now, let's allow any authenticated user to update a member.
        // We can add role-based authorization later if needed.
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $memberId = $this->route('member')->member_id;

        return [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'family_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:50',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('members')->ignore($memberId, 'member_id'),
            ],
            'address' => 'required|string',
            'date_of_birth' => 'required|date|before:today',
            'membership_type' => 'required|in:community,student',
            'membership_category' => 'required|in:adult,youth,child,university-student',
            'role_in_church' => 'nullable|string|max:255',
            'baptism_status' => 'required|in:baptized,not-baptized,pending',
            'date_of_baptism' => 'nullable|date|before_or_equal:today|required_if:baptism_status,baptized',
            'membership_date' => 'required|date|before_or_equal:today',
            'membership_status' => 'required|in:active,inactive,transferred,archived',
            'sabbath_school_class_id' => 'nullable|exists:sabbath_school_classes,id',
        ];
    }
}
