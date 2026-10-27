<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $formType = (int) $request->input('form', 1);

        if ($formType === 2) {
            $request->validate([
                'currentPassword' => 'required|string',
                'newPassword' => 'required|string|min:6',
                'confirmPassword' => 'required|same:newPassword',
            ], [
                'currentPassword.required' => 'Le mot de passe actuel est requis.',
                'newPassword.required' => 'Le nouveau mot de passe est requis.',
                'newPassword.min' => 'Le nouveau mot de passe doit comporter au moins 6 caractères.',
                'confirmPassword.same' => 'Les deux mots de passe ne correspondent pas.',
            ]);

            if (!Hash::check($request->input('currentPassword'), $user->password)) {
                return response()->json([
                    'message' => 'Le mot de passe actuel est incorrect.',
                    'errors' => [
                        'currentPassword' => ['Le mot de passe actuel est incorrect.']
                    ]
                ], 422);
            }

            $user->update([
                'password' => Hash::make($request->input('newPassword'))
            ]);

            return response()->json([
                'message' => 'Mot de passe modifié avec succès'
            ]);
        }

        // form 1 : Mise à jour des informations de profil
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact' => 'nullable|string|max:25',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'firstname.required' => 'Le prénom est obligatoire.',
            'email.required' => "L'adresse email est obligatoire.",
            'email.email' => "L'adresse email n'est pas valide.",
            'email.unique' => "Cette adresse email est déjà utilisée.",
        ]);

        $user->update($validated);

        return response()->json([
            'user' => $user->fresh(),
            'message' => 'Profil mis à jour avec succès'
        ]);
    }
}
