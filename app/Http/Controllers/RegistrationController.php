<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = Registration::with(['student', 'schedule'])->paginate(10);
        $schedules = Schedule::with(['practicum'])->get();
        return view('registrations.index', compact(['registrations', 'schedules']));
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
        $validator = $request->validate([
            'schedule_id' => 'required',
        ]);

        try {
            $registration = Registration::create([
                'student_id' => $request->user()->student->id,
                'schedule_id' => $request->schedule_id,
                'registration_date' => now(),
                'status' => 'pending',
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Data jadwal berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Tangani error jika gagal menyimpan
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Gagal menambahkan data. ' . $e->getMessage());
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registration $registration)
    {
        try {
            $registration->delete();
            return redirect()->back()->with('success', "Jadwal {$registration->schedule->practicum->name} {$registration->schedule->class} berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus ruangan: ' . $e->getMessage());
        }
    }
}
