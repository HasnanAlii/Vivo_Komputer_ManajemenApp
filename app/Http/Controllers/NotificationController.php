<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Service;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        $services = Service::all();
        return view('notifications.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tglKirim' => 'required|date',
            'pesan' => 'required|string|max:50',
            'idService' => 'required|exists:services,idService',
        ]);

        Notification::create($request->all());

        return redirect()->route('notifications.index')->with('success', 'Notification created successfully.');
    }

    public function edit(Notification $notification)
    {
        $services = Service::all();
        return view('notifications.edit', compact('notification', 'services'));
    }

    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'tglKirim' => 'required|date',
            'pesan' => 'required|string|max:50',
            'idService' => 'required|exists:services,idService',
        ]);

        $notification->update($request->all());

        return redirect()->route('notifications.index')->with('success', 'Notification updated successfully.');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully.');
    }
}
