<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        if ($this->routeIs('questions.store')) {
            return [
                'question' => ['required', 'string'],
                'correct_answer' => ['required']
            ];
        }

        if ($this->routeIs('questions.update')) {
            $question = $this->route('question');
            return [
                'question' => ['required', 'string'],
            ];
        }
    }

    public function messages(): array
    {
        return [
            'question.required' => 'Pergunta é obrigatória',
            'correct_answer.required' => 'Resposta correta é obrigatória',
        ];
    }
}
