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
        $events = Event::all();

        $formattedEvents = $events->map(function ($event) {
            
            // FullCalendar end date bersifat eksklusif (tidak termasuk).
            $endDate = $event->end_date ? \Carbon\Carbon::parse($event->end_date)->addDay()->format('Y-m-d') : null;

            return [
                'id'    => $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end'   => $endDate,
                'allDay' => true,
                'backgroundColor' => '#10B981', // Hijau
                'borderColor' => '#059669',     // Hijau gelap
            ];
        });

        return response()->json($formattedEvents);
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
        ]);

        // Simpan ke database
        Event::create([
            'title' => $request->input('title'),
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ]);

        return redirect()->route('home')->with('success', 'Event berhasil ditambahkan!');
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
        ]);

        $event = Event::findOrFail($id);

        $event->update([
            'title' => $request->input('title'),
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ]);

        return redirect()->route('home')->with('success', 'Event berhasil diupdate!');
    }

    /**
     * Menghapus event dari database
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('home')->with('success', 'Event berhasil dihapus!');
    }
    
}
