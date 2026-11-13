<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event; // Import model Event
use App\Models\User;  // Import model User

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil data statistik dari database
        $eventCount = Event::count();
        $userCount = User::where('is_admin', false)->count(); // Hanya menghitung pengguna biasa
        $recentEvents = Event::latest()->take(5)->get(); // Mengambil 5 acara terbaru

        // Mengirim semua data ke view menggunakan fungsi compact()
        return view('admin.dashboard', compact('eventCount', 'userCount', 'recentEvents'));
    }
}
