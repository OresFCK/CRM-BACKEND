<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'required|integer|min:1',
            'per_page' => 'required|integer|min:1',
        ];
    }

    public function page(): int
    {
        return intval($this->input('page', 1));
    }

    public function perPage(): int
    {
        return intval($this->input('per_page', 10));
    }
}
