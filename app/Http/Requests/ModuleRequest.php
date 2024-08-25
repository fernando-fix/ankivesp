<?php

namespace App\Http\Requests;

use App\Models\Module;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ModuleRequest extends FormRequest
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
        if ($this->routeIs('admin.modules.store')) {
            return [
                'name'      => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    Rule::unique('modules', 'name')->where('course_id', $this->input('course_id'))
                ],
                'due_date'  => ['required', 'date'],
            ];
        }

        if ($this->routeIs('admin.modules.update')) {
            $module = $this->route('module');
            return [
                'name'     => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    Rule::unique('modules', 'name')
                        ->where('course_id', $module->course_id)
                        ->ignore($module->id),
                ],
            ];
        }
    }
}
