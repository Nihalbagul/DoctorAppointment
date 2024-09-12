<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Slot;
use App\Models\Fee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;

class AppointmentController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('appointments.index', compact('doctors'));
    }

    public function showSlots(Request $request)
    {
        $doctor_id = $request->input('doctor_id');
        $appointment_date = $request->input('appointment_date');
        $slots = Slot::where('doctor_id', $doctor_id)
                      ->where('appointment_date', $appointment_date)
                      ->where('is_booked', false)
                      ->get();
        return response()->json($slots);
    }

    public function bookAppointment(Request $request)
    {
        $slot_id = $request->input('slot_id');
        $slot = Slot::find($slot_id);
        $slot->is_booked = true;
        $slot->save();

        // Assuming user is authenticated
        $user = Auth::user();
        Mail::to($user->email)->send(new AppointmentConfirmation($slot));

        return response()->json(['message' => 'Appointment booked successfully.']);
    }
}
