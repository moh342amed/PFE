<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Notifications\RegistrationReceivedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = auth()->user()->registrations()->with('event')->latest()->get();
        return view('user.applications.index', compact('registrations'));
    }

    public function store(Request $request, Event $event)
    {
        // 1. Check seat availability
        if ($event->available_seats <= 0) {
            return back()->with('error', 'Sorry, this event is fully booked.');
        }

        // 2. Prevent duplicate registrations
        $exists = Registration::where('user_id', auth()->id())
                              ->where('event_id', $event->id)
                              ->exists();
        if ($exists) {
            return back()->with('info', 'You have already registered for this event.');
        }

        // 3. Create registration
        DB::transaction(function () use ($event) {
            $registration = Registration::create([
                'user_id' => auth()->id(),
                'event_id' => $event->id,
                'status' => 'pending'
            ]);

            // Notify student of received status
            auth()->user()->notify(new RegistrationReceivedNotification($registration));
        });

        return redirect()->route('my.applications')->with('success', 'Your registration request has been submitted. Please await admin approval.');
    }
}
