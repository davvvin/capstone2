<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting untuk mendapatkan user yang login

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Anda bisa menambahkan logika di sini untuk mengarahkan ke dashboard spesifik peran
        // atau menampilkan data umum
        if ($user->hasRole('administrator')) {
            // Mungkin redirect ke admin dashboard atau tampilkan view admin
            return redirect()->route('admin.dashboard'); // Jika ada admin dashboard terpisah
        } elseif ($user->hasRole('member')) {
            // Tampilkan dashboard member atau data member
        } // Tambahkan kondisi untuk peran lain

        // View dashboard umum jika tidak ada pengalihan spesifik
        return view('dashboard'); // Pastikan view 'dashboard.blade.php' ada
    }
}