<?php

namespace App\Http\Requests\Admin\api\v1\user;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|unique:users,name,' . $this->route('user')->id,
            'email' => 'nullable|unique:users,email,' . $this->route('user')->id,
            'roles' => 'nullable|array',
            'roles.*' => 'integer|exists:roles,id',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = [];
        foreach ($validator->errors()->getMessages() as $field => $messages) {
            if (strpos($field, 'roles.') === 0) {
                $permissionId = explode('.', $field)[1];
                $errors['roles'][] = $permissionId;
            } else {
                $errors[$field] = $messages[0];
            }
        }

        if (isset($errors['roles'])) {
            $invalidRoleIds = implode(' , ', $errors['roles']);
            $errors['roles'] = count($errors['roles']) > 1 ? "Roles index's {$invalidRoleIds} are invalid." : "Roles index's {$invalidRoleIds} is invalid.";
        }

        throw new HttpResponseException(response()->json([
            'message' => 'Failed to create new user.',
            'errors' => $errors,
            'status' => false
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
