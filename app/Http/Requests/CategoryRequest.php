<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'is_publish' => ['boolean'],
        ];

        if ($this->isMethod('PUT')) {
            $rules['name'] = ['required', 'string', 'max:255', 'unique:categories,name,' . $this->category->id];
        } else {
            $rules['name'] = ['required', 'string', 'max:255', 'unique:categories,name'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bidang nama wajib terisi.',
            'name.string' => 'Bidang nama harus berupa text.',
            'name.max' => 'Jumlah karakter pada bidang nama melewati kapasitas',
            'name.unique' => 'Nama telah terpakai',
            'is_publish.boolean' => 'Bidang publish harus berupa boolean (true/false)',
        ];
    }
}
