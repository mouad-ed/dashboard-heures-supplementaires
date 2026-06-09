<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'groupe' => 'required|string|max:255',
            'enseignant_id' => 'required|exists:enseignants,id',
            'prix_heure' => 'required|numeric|min:0',
        ];
    }
}