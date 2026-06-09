<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show register page
     */
    public function create(): View
    {
        // only admin can access register page
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function store(Request $request): RedirectResponse
    {
        // only admin can create users
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],

            'role' => [
                'required',
                'in:admin,user',
            ],
        ]);

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        return redirect()
            ->route('dashboard')
            ->with('success', 'Utilisateur créé avec succès');
    }
}