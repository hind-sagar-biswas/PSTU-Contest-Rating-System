<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreContestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date'               => ['required', 'date', 'before_or_equal:today'],
            'results'            => ['required', 'array', 'min:1'],
            'results.*.name'     => ['required', 'string'],
            'results.*.standing' => ['required', 'integer', 'min:1'],
            'results.*.solved'   => ['required', 'integer', 'min:0'],
            'results.*.penalty'  => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.before_or_equal'    => 'The held‑on date cannot be in the future.',
            'results.required'        => 'You must supply at least one result.',
            'results.array'           => 'Results must be an array of entries.',
            'results.*.name.required'     => 'Each entry needs a name.',
            'results.*.standing.integer'  => 'Standing must be an integer.',
            'results.*.solved.integer'    => 'Solved must be an integer.',
            'results.*.penalty.integer'   => 'Penalty must be an integer.',
        ];
    }
}
