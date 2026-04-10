<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct()
    {
        
    }

    public function show($userId = null): View
    {
        $user = auth()->user();
        
        if (!$userId) {
            $userId = $user->id;
        }

        $targetUser = User::findOrFail($userId);

        if (!$this->canAccessUser($user, $targetUser)) {
            abort(403, 'No tienes permisos para ver este perfil.');
        }

        return view('profile.show', compact('targetUser', 'user'));
    }

    public function edit($userId = null): View
    {
        $user = auth()->user();
        
        if (!$userId) {
            $userId = $user->id;
        }

        $targetUser = User::findOrFail($userId);

        if (!$this->canEditUser($user, $targetUser)) {
            abort(403, 'No tienes permisos para editar este perfil.');
        }

        return view('profile.edit', compact('targetUser', 'user'));
    }

    public function update(Request $request, $userId): RedirectResponse
    {
        $user = auth()->user();
        $targetUser = User::findOrFail($userId);

        if (!$this->canEditUser($user, $targetUser)) {
            abort(403, 'No tienes permisos para editar este perfil.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($targetUser->id)],
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
            'date_of_birth' => 'nullable|date',
            'preferences' => 'nullable|array'
        ];

        if ($user->hasAdminAccess()) {
            $rules['role'] = 'required|in:teacher,student,parent,admin,director';
            $rules['is_active'] = 'boolean';
            $rules['institution_id'] = 'nullable|string';
        }

        if ($user->role === 'parent' && $targetUser->id !== $user->id) {
            $rules = [
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
            ];
        }

        $validatedData = $request->validate($rules);

        if ($request->hasFile('avatar')) {
            if ($targetUser->avatar) {
                Storage::disk('public')->delete($targetUser->avatar);
            }
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $targetUser->update($validatedData);

        return redirect()->route('profile.show.user', $targetUser->id)
            ->with('success', 'Perfil actualizado exitosamente.');
    }

    public function updatePassword(Request $request, $userId): RedirectResponse
    {
        $user = auth()->user();
        $targetUser = User::findOrFail($userId);

        if ($targetUser->id !== $user->id && !$user->hasAdminAccess()) {
            abort(403, 'No tienes permisos para cambiar esta contraseña.');
        }

        $rules = [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ];

        if ($user->hasAdminAccess() && $targetUser->id !== $user->id) {
            unset($rules['current_password']);
        }

        $request->validate($rules);

        if (isset($rules['current_password'])) {
            if (!Hash::check($request->current_password, $targetUser->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
            }
        }

        $targetUser->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Contraseña actualizada exitosamente.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function canAccessUser($user, $targetUser): bool
    {
        if ($user->hasAdminAccess()) {
            return true;
        }

        if ($user->id === $targetUser->id) {
            return true;
        }

        if ($user->role === 'parent') {
            return in_array($targetUser->id, $user->children_ids ?? []);
        }

        if ($user->role === 'teacher' && $targetUser->role === 'student') {
            $teacherClassrooms = $user->classrooms->pluck('id')->toArray();
            $studentClassrooms = $targetUser->classroom_ids ?? [];
            return !empty(array_intersect($teacherClassrooms, $studentClassrooms));
        }

        return false;
    }

    private function canEditUser($user, $targetUser): bool
    {
        if ($user->hasAdminAccess()) {
            return true;
        }

        if ($user->id === $targetUser->id) {
            return true;
        }

        if ($user->role === 'parent' && $targetUser->role === 'student') {
            return in_array($targetUser->id, $user->children_ids ?? []);
        }

        return false;
    }
}