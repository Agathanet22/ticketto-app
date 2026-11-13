<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'min_price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('poster')) {
            // PERBAIKAN: Menyimpan ke direktori 'posters' di dalam disk 'public'
            // Ini akan menyimpan file di 'storage/app/public/posters'
            // dan mengembalikan path 'posters/namafile.jpg'
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $validated['slug'] = Event::generateSlug($request->name);

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return redirect()->route('events.show', $event->slug);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'min_price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('poster')) {
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            // PERBAIKAN: Menyimpan ke direktori 'posters' di dalam disk 'public'
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        if ($request->name !== $event->name) {
            $validated['slug'] = Event::generateSlug($request->name);
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->poster) {
            // PERBAIKAN: Memastikan file dihapus dari disk 'public'
            Storage::disk('public')->delete($event->poster);
        }
        
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil dihapus.');
    }
}
