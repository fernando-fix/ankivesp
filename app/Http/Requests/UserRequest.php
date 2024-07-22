<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if ($this->routeIs('users.store')) {
            return [
                'name'      => ['required', 'string', 'min:3', 'max:255'],
                'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password'  => ['required', 'string', 'min:8', 'max:255'],
            ];
        }

        if ($this->routeIs('users.update')) {
            $user = $this->route('user');
            return [
                'name'      => ['required', 'string', 'min:3', 'max:255'],
                'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $user->id],
            ];
        }
    }
}
