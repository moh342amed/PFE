<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Registration;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    public function show(Registration $registration)
    {
        if ($registration->user_id !== auth()->id() || $registration->status !== 'approved') {
            abort(403);
        }

        $qrCode = QrCode::size(200)->generate(route('admin.registrations.index', ['search' => $registration->id]));

        return view('user.applications.ticket', compact('registration', 'qrCode'));
    }
}
