<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        if ($this->routeIs('admin.roles.store')) {
            return [
                'name'      => ['required', 'string', 'min:3', 'max:255', 'unique:' . Role::class],
            ];
        }

        if ($this->routeIs('admin.roles.update')) {
            $role = $this->route('role');
            return [
                'name'      => ['required', 'string', 'min:3', 'max:255', 'unique:' . Role::class . ',name,' . $role->id],
            ];
        }
    }
}
