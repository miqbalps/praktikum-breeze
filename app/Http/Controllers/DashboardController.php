<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Schedule;
use App\Models\Assistant;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\PracticumAssistant;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $studentId = null;
        $assistantId = null;

        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();

            // Check if the user has a student
            if ($user->student) {
                $studentId = $user->student->id;
            }

            // Check if the user has an assistant
            if ($user->assistant) {
                $assistantId = $user->assistant->id;
            }
        }

        // Use the null coalescing operator to avoid null values
        $registrations = Registration::where('student_id', $studentId ?? 0)->count();
        $pracassistants = PracticumAssistant::where('assistant_id', $assistantId ?? 0)->count();
        $rooms = Room::count();
        $assistants = Assistant::where('status', 'active')->count();
        $schedules = Schedule::count();
        $assistant_approvals = Assistant::where('status', 'pending')->count();
        $registration_approvals = Registration::where('status', 'pending')->count();

        return view('dashboard', compact(['registrations', 'pracassistants', 'rooms', 'assistants', 'schedules', 'assistant_approvals', 'registration_approvals']));
    }
}
