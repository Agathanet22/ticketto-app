<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request, TicketType $ticketType)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');

        DB::beginTransaction();

        try {
            $ticket = TicketType::lockForUpdate()->find($ticketType->id);

            if ($ticket->quota < $quantity) {
                return back()->with('error', 'Maaf, kuota tiket tidak mencukupi.');
            }

            $ticket->quota -= $quantity;
            $ticket->sold += $quantity;
            $ticket->save();

            Booking::create([
                'booking_code' => 'TICKETTO-' . Str::upper(Str::random(8)),
                'user_id' => Auth::id(),
                'event_id' => $ticket->event_id,
                'ticket_type_id' => $ticket->id,
                'quantity' => $quantity,
                'total_price' => $ticket->price * $quantity,
                'status' => 'paid',
            ]);
            
            DB::commit();

            // PERBAIKAN: Mengarahkan ke route 'user.tickets' yang sudah ada
            return redirect()->route('user.tickets')->with('success', 'Pemesanan tiket berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Anda bisa menambahkan log di sini untuk melihat error sebenarnya: \Log::error($e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.');
        }
    }

    /**
     * Display the user's bookings.
     */
    public function myTickets()
    {
        $bookings = Booking::where('user_id', Auth::id())
                            ->with(['event', 'ticketType'])
                            ->latest()
                            ->get();
        
        return view('user.tickets.index', compact('bookings'));
    }
}
