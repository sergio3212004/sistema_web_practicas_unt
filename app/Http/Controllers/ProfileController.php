<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Debug
        \Log::info('Profile Update Request', $request->all());

        // ===== ALUMNO =====
        if ($user->alumno) {
            $updateData = [];

            if ($request->filled('telefono')) {
                $updateData['telefono'] = $request->telefono;
            }

            if ($request->filled('cv_link')) {
                $updateData['cv'] = $request->cv_link;
            }

            if (!empty($updateData)) {
                $user->alumno->update($updateData);
                \Log::info('Alumno actualizado', $updateData);
            }
        }

        // ===== USUARIO =====
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'alumno-updated');
    }


}
