<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use Spatie\Permission\Models\Role as PermissionRole;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
        
public function index()
{
    $users = User::all();

    if (Auth::user()->hasRole('admin')) {
        return view('dashboard', compact('users'));
    } else {
        return view('user', compact('users'));
    }
}



public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'role' => 'required|in:admin,user',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt('password'), 
    ]);

    $role = Role::where('name', $request->role)->first();
    $user->assignRole($role->name); 

    return redirect()->route('index')->with('success', 'Utilisateur ajouté avec succès.');
}


public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    // Redirection avec un message de succès
    return redirect()->route('index')->with('success', 'Utilisateur supprimé avec succès.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|in:admin,user', 
    ]);

    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,

    ]);

    // Mettre à jour le rôle de l'utilisateur
    $role = Role::where('name', $request->role)->first();
    $user->syncRoles([$role->name]); // Assurez-vous que seul un rôle est affecté, donc utilisez syncRoles()

    // Redirection avec un message de succès
    return redirect()->route('index')->with('success', 'Utilisateur mis à jour avec succès.');
}




}