<?php

namespace Leafwrap\RoleSanctions\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Leafwrap\RoleSanctions\Traits\Helper;

class RoleRequest extends FormRequest
{
    use Helper;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'             => 'sometimes|required',
            'description'      => 'sometimes',
            'grant_permission' => 'sometimes|required|boolean',
            'permissions'      => 'sometimes|required_if:grant_permission,=,false|array',
            'status'           => 'sometimes|' . Rule::in(['active', 'inactive']),
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        if ($this->wantsJson() || $this->ajax()) {
            throw new HttpResponseException($this->validateError($validator->errors()));
        }
        parent::failedValidation($validator);
    }

}
