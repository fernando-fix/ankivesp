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
        if ($this->routeIs('admin.lessons.store')) {
            return [
                'name'      => [],
                'transcription' => ['nullable', 'min:1000', 'max:30000'],
            ];
        }

        if ($this->routeIs('admin.lessons.update')) {
            $lesson = $this->route('lesson');
            return [
                'name'     => [],
                'transcription' => ['nullable', 'min:1000', 'max:30000'],
            ];
        }
    }

    public function messages()
    {
        return [
            'transcription.min' => 'A transcrição deve ter pelo menos 1000 caracteres',
            'transcription.max' => 'A transcrição deve ter pelo menos 30000 caracteres',
        ];
    }

    public function attributes()
    {
        return [
            'transcription' => 'transcrição',
        ];
    }
}
