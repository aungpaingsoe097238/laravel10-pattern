<?php

namespace App\Http\Requests\api\v1\role;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AssignRoleRequest extends FormRequest
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
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ];
    }

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
            $errors['permissions'] = count($errors['permissions']) > 1 ? "Permissions index's {$invalidPermissionIds} are invalid." : "{$invalidPermissionIds} is invalid.";
        }

        throw new HttpResponseException(response()->json([
            'message' => 'Permissions assigned to role failed.',
            'errors' => $errors,
            'status' => 2
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
