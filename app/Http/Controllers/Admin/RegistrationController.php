<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Event;
use App\Notifications\RegistrationStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with(['user', 'event'])->latest()->get();
        return view('admin.registrations.index', compact('registrations'));
    }

    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($validated, $registration) {
                if ($validated['status'] == 'approved' && $registration->status != 'approved') {
                    // Check if seats are still available
                    if ($registration->event->available_seats > 0) {
                        $registration->event->decrement('available_seats');
                    } else {
                        throw new \Exception('No seats available.');
                    }
                } elseif ($validated['status'] == 'rejected' && $registration->status == 'approved') {
                    // Revert seat if it was previously approved
                    $registration->event->increment('available_seats');
                }

                $registration->update($validated);
                
                // Notify the student of the update
                $registration->user->notify(new RegistrationStatusNotification($registration, $validated['status']));
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Registration status updated.');
    }

    public function export(Event $event)
    {
        $registrations = $event->registrations()->with('user')->where('status', 'approved')->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.attendance', [
            'event' => $event,
            'registrations' => $registrations
        ]);

        return $pdf->download("attendance_{$event->id}.pdf");
    }
}
