<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource for a specific event.
     */
    public function index(Event $event)
    {
        $ticketTypes = $event->ticketTypes;
        return view('admin.ticket_types.index', compact('event', 'ticketTypes'));
    }

    /**
     * Show the form for creating a new resource for a specific event.
     */
    public function create(Event $event)
    {
        return view('admin.ticket_types.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
        ]);

        $event->ticketTypes()->create($validated);

        return redirect()->route('admin.events.ticket-types.index', $event)
                         ->with('success', 'Jenis tiket berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketType $ticketType)
    {
        return view('admin.ticket_types.edit', compact('ticketType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketType $ticketType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
        ]);

        $ticketType->update($validated);

        // PERBAIKAN: Mengirimkan objek Event ($ticketType->event), bukan ID-nya
        return redirect()->route('admin.events.ticket-types.index', $ticketType->event)
                         ->with('success', 'Jenis tiket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketType $ticketType)
    {
        // PERBAIKAN: Mengambil objek Event sebelum menghapus tiket
        $event = $ticketType->event;
        $ticketType->delete();

        // Mengirimkan objek Event yang sudah disimpan ke route
        return redirect()->route('admin.events.ticket-types.index', $event)
                         ->with('success', 'Jenis tiket berhasil dihapus.');
    }
}
