<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Assistant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assistants = Assistant::with('user')->paginate(3); // Adjust the number of items per page as needed
        return view('assistants.index', compact('assistants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'type' => 'required',
            'status' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $assistantRole = Role::where('slug', 'assistant')->first();
        $user->roles()->attach($assistantRole);

        $assistant = Assistant::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        event(new Registered($user));

        return redirect()->back()->with('success', 'Data assistant berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assistant $assistant)
    {
        $validatedData = $request->validate([
            'type' => 'required',
            'status' => 'required'
        ]);

        $assistant->update($validatedData);

        return redirect()->back()->with('success', 'Ruangan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assistant $assistant)
    {
        try {
            $assistant->delete();
            return redirect()->back()->with('success', "Asisten {$assistant->user->name} berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus Asisten: ' . $e->getMessage());
        }
    }
}
