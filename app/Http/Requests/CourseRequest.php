<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->routeIs('courses.store')) {
            return [
                'name'      => ['required', 'string', 'min:3', 'max:255', 'unique:' . Course::class],
                'year'      => ['required', 'numeric', 'min:2000', 'max:9999'],
                'semester'  => ['required', 'numeric', 'min:1', 'max:2'],
            ];
        }

        if ($this->routeIs('courses.update')) {
            $course = $this->route('course');
            return [
                'name'     => ['required', 'string', 'min:3', 'max:255', 'unique:' . Course::class . ',name,' . $course->id],
                'year'      => ['required', 'numeric', 'min:2000', 'max:9999'],
                'semester'  => ['required', 'numeric', 'min:1', 'max:2'],
            ];
        }
    }
}
