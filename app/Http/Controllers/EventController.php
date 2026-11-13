<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request; // Import class Request

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Tambahkan Request $request
    {
        // Memulai query builder
        $query = Event::query();

        // Cek jika ada input pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            // Menambahkan kondisi WHERE untuk memfilter berdasarkan nama atau lokasi
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
        }

        // Mengambil data yang sudah difilter (atau semua data jika tidak ada pencarian)
        // dan menambahkan paginasi
        $events = $query->latest()->paginate(12)->withQueryString();

        return view('user.events.index', compact('events'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        // Memuat relasi ticketTypes untuk event yang diambil.
        $event->load('ticketTypes');

        // Mengirimkan objek event yang sudah lengkap ke view.
        return view('user.events.show', compact('event'));
    }
}
