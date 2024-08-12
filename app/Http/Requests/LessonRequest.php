<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
        if ($this->routeIs('lessons.store')) {
            return [
                'name'      => [],
            ];
        }

        if ($this->routeIs('lessons.update')) {
            $lesson = $this->route('lesson');
            return [
                'name'     => [],
            ];
        }
    }
}
