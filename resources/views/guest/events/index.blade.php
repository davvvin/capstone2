@extends('layouts.guest') {{-- Menggunakan layout publik Anda --}}

@section('title', 'Daftar Event')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Daftar Event Mendatang</h1>

    @if($events->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform transition duration-300 hover:scale-105">
                @if($event->poster_url)
                    <img src="{{ asset('storage/' . $event->poster_url) }}" alt="Poster {{ $event->name }}" class="w-full h-48 object-cover">
                    {{-- Pastikan Anda sudah menjalankan `php artisan storage:link` --}}
                    {{-- Dan poster disimpan di `storage/app/public/namafolder/namafile.jpg` --}}
                @else
                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                        <i class="fas fa-image fa-3x text-gray-500"></i>
                    </div>
                @endif
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2 text-gray-700 truncate" title="{{ $event->name }}">{{ $event->name }}</h2>
                    <p class="text-sm text-gray-500 mb-1">
                        <i class="fas fa-calendar-alt mr-2 text-indigo-500"></i>{{ $event->event_date->translatedFormat('l, d M Y, H:i') }} WIB
                    </p>
                    <p class="text-sm text-gray-500 mb-1 truncate">
                        <i class="fas fa-map-marker-alt mr-2 text-indigo-500"></i>{{ $event->location }}
                    </p>
                    <p class="text-sm text-gray-500 mb-3 truncate">
                        <i class="fas fa-microphone-alt mr-2 text-indigo-500"></i>Narasumber: {{ $event->speaker ?? '-' }}
                    </p>
                    <p class="text-lg font-bold text-indigo-600 mb-4">
                        @if($event->registration_fee > 0)
                            Rp {{ number_format($event->registration_fee, 0, ',', '.') }}
                        @else
                            Gratis
                        @endif
                    </p>
                    <a href="{{ route('guest.events.show', $event->id) }}"
                       class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $events->links() }} {{-- Menampilkan link paginasi --}}
        </div>
    @else
        <p class="text-center text-gray-600 mb-6">Belum ada event yang tersedia saat ini. Lihat beberapa contoh di bawah ini:</p>
        {{-- Placeholder Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-pulse">
            @for ($i = 0; $i < 3; $i++)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="w-full h-48 bg-gray-300"></div>
                <div class="p-6">
                    <div class="h-6 bg-gray-300 rounded w-3/4 mb-2"></div>
                    <div class="h-4 bg-gray-300 rounded w-full mb-1"></div>
                    <div class="h-4 bg-gray-300 rounded w-5/6 mb-1"></div>
                    <div class="h-4 bg-gray-300 rounded w-4/6 mb-3"></div>
                    <div class="h-6 bg-gray-300 rounded w-1/3 mb-4"></div>
                    <div class="h-10 bg-gray-400 rounded-md w-full"></div>
                </div>
            </div>
            @endfor
        </div>
    @endif
</div>
@endsection
