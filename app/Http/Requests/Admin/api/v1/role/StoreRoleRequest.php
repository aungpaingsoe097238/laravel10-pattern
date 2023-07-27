<?php

namespace App\Http\Requests\Admin\api\v1\role;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
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
            if (strpos($field, 'permissions.') === 0) {
                $permissionId = explode('.', $field)[1];
                $errors['permissions'][] = $permissionId;
            } else {
                $errors[$field] = $messages[0];
            }
        }

        if (isset($errors['permissions'])) {
            $invalidPermissionIds = implode(' , ', $errors['permissions']);
            $errors['permissions'] = count($errors['permissions']) > 1 ? "Permissions index's {$invalidPermissionIds} are invalid." : "Permissions index's {$invalidPermissionIds} is invalid.";
        }

        throw new HttpResponseException(response()->json([
            'message' => 'Failed to create new role.',
            'errors' => $errors,
            'status' => false
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
