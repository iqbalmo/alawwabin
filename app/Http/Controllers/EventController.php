<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;


class EventController extends Controller
{
    /**
     * Menampilkan semua event untuk kalender.
     * Jika request via AJAX (FullCalendar) -> kembalikan JSON
     * Jika bukan -> kembalikan view home
     */
    public function index(Request $request)
    {
        // Jika request via AJAX (FullCalendar) atau memiliki parameter 'start' (standar FullCalendar)
        if ($request->ajax() || $request->has(['start', 'end'])) {
            $events = Event::all();

            $formattedEvents = $events->map(function ($event) {
                return [
                    'id'    => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date->format('Y-m-d'),
                    'end'   => $event->end_date ? $event->end_date->format('Y-m-d') : null,
                    'allDay' => true, // Force all-day untuk konsistensi tampilan kalender
                    'extendedProps' => [
                        'start_time' => $event->start_time ? $event->start_time->format('H:i') : null,
                        'end_time' => $event->end_time ? $event->end_time->format('H:i') : null,
                    ],
                ];
            });

            return response()->json($formattedEvents);
        }

        // Jika bukan AJAX -> kembalikan view management list
        $events = Event::orderBy('start_date', 'desc')->get();
        return view('events.index', compact('events'));
    }

    /**
     * Menampilkan form untuk create event
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Menyimpan event baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time'   => 'nullable|date_format:H:i|after:start_time',
        ]);

        // Simpan ke database
        Event::create([
            'title' => $request->input('title'),
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
            'start_time' => $request->input('start_time'),
            'end_time'   => $request->input('end_time'),
        ]);

        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit event
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    /**
     * Mengupdate data event yang dipilih
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time'   => 'nullable|date_format:H:i|after:start_time',
        ]);

        $event = Event::findOrFail($id);

        $event->update([
            'title' => $request->input('title'),
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
            'start_time' => $request->input('start_time'),
            'end_time'   => $request->input('end_time'),
        ]);

        return redirect()->route('events.index')->with('success', 'Event berhasil diupdate!');
    }

    /**
     * Menghapus event dari database
     */
    public function destroy(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        // Jika request via AJAX, return JSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Event berhasil dihapus!'
            ]);
        }

        // Jika bukan AJAX, redirect seperti biasa
        return redirect()->route('home')->with('success', 'Event berhasil dihapus!');
    }
    
}
