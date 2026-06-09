<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EleveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Tous les utilisateurs peuvent envoyer ce formulaire
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'parent_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'status' => 'required|in:en_attente,payé,en_retard',
        ];
    }

    /**
     * Custom error messages (optionnel)
     */
    public function messages(): array
    {
        return [
            'name.required' => "Le nom de l'élève est obligatoire.",
            'phone.required' => "Le numéro de téléphone est obligatoire.",
            'amount.numeric' => "La mensualité doit être un nombre.",
            'payment_date.required' => "La date d'échéance est obligatoire.",
            'status.in' => "Le statut sélectionné n'est pas valide.",
        ];
    }
}