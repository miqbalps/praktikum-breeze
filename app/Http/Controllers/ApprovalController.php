<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\PracticumAssistant;

class ApprovalController extends Controller
{
    public function index(){
        $registrations = Registration::with(['student', 'schedule'])->paginate(10);
        $assistants = Assistant::with('user')->paginate(10);
        return view('approvals.index', compact(['registrations', 'assistants']));
    }

    public function approveRegistration($id)
    {
        try {
            // Update the registration status to 'approved'
            $registration = Registration::find($id);
            $registration->status = 'approved';
            $registration->save();

            return redirect()->back()->with('success', 'Pendaftaran praktikum peserta disetujui.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Registration approval error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat persetujuan.');
        }
    }

    public function rejectRegistration($id)
    {
        try {
            // Update the registration status to 'approved'
            $registration = Registration::find($id);
            $registration->status = 'rejected';
            $registration->save();

            return redirect()->back()->with('success', 'Pendaftaran praktikum peserta ditolak.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Registration approval error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat persetujuan.');
        }
    }

    public function approveAssistant($id)
    {
        try {
            // Update the registration status to 'approved'
            $assistant = Assistant::find($id);
            $assistant->user->assignRole('assistant');
            $assistant->status = 'active';
            $assistant->save();

            return redirect()->back()->with('success', 'Pendaftaran asisten disetujui.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Assistant approval error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat persetujuan.');
        }
    }

    public function rejectAssistant($id)
    {
        try {
            // Update the registration status to 'approved'
            $assistant = Assistant::find($id);
            $assistant->status = 'inactive';
            $assistant->save();

            return redirect()->back()->with('success', 'Pendaftaran asisten ditolak.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Assistant approval error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat persetujuan.');
        }
    }
}
