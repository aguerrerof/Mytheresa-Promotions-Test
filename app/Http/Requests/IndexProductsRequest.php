<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexProductsRequest extends FormRequest
{
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
        return [
            'category' => 'string',
            'price_less_than' => 'numeric|min:0',
            'per_page' => 'integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'category.exists' => 'The selected category does not exist.',
        ];
    }

    public function getPerPage(): int
    {
        return $this->validated()['per_page'] ?? 5;
    }

    public function getCategory(): ?string
    {
        return $this->validated()['category'] ?? null;
    }

    public function getPriceLessThan(): ?int
    {
        return $this->validated()['price_less_than'] ?? null;
    }
}
