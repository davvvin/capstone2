@extends('layouts.guest') {{-- Atau layout publik Anda --}}

@section('title', $event->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        @if($event->poster_url)
            <img src="{{ asset('storage/' . $event->poster_url) }}" alt="Poster {{ $event->name }}" class="w-full h-64 md:h-96 object-cover">
        @else
            <div class="w-full h-64 md:h-96 bg-gray-300 flex items-center justify-center">
                <i class="fas fa-image fa-5x text-gray-400"></i>
            </div>
        @endif

        <div class="p-6 md:p-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $event->name }}</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Detail Event:</h3>
                    <p class="text-gray-600 mb-2"><i class="fas fa-calendar-alt fa-fw mr-2 text-indigo-500"></i><strong>Tanggal & Waktu:</strong> {{ $event->event_date->translatedFormat('l, d F Y, H:i') }} WIB</p>
                    <p class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt fa-fw mr-2 text-indigo-500"></i><strong>Lokasi:</strong> {{ $event->location }}</p>
                    <p class="text-gray-600 mb-2"><i class="fas fa-microphone-alt fa-fw mr-2 text-indigo-500"></i><strong>Narasumber:</strong> {{ $event->speaker ?? 'Akan diumumkan' }}</p>
                    <p class="text-gray-600 mb-2"><i class="fas fa-users fa-fw mr-2 text-indigo-500"></i><strong>Maks. Peserta:</strong> {{ $event->max_participants ? $event->max_participants . ' orang' : 'Tidak dibatasi' }}</p>
                    <p class="text-2xl font-bold text-indigo-600 mt-4">
                        @if($event->registration_fee > 0)
                            Biaya Registrasi: Rp {{ number_format($event->registration_fee, 0, ',', '.') }}
                        @else
                            Biaya Registrasi: Gratis
                        @endif
                    </p>
                </div>
                <div>
                    {{-- Anda bisa menambahkan informasi panitia penyelenggara jika ada --}}
                    {{-- @if($event->creator)
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Diselenggarakan oleh:</h3>
                    <p class="text-gray-600 mb-2">{{ $event->creator->name }}</p>
                    @endif --}}
                </div>
            </div>

            <div class="prose max-w-none text-gray-700 mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Deskripsi Event:</h3>
                {!! nl2br(e($event->description)) !!}
            </div>

            <div class="mt-8 text-center">
                @guest
                    <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300 mr-2">
                        Daftar Akun untuk Ikut Event
                    </a>
                    <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300">
                        Login untuk Mendaftar
                    </a>
                @endguest
                @auth
                    @if(Auth::user()->hasRole('member'))
                        {{-- Cek apakah user sudah terdaftar di event ini atau belum --}}
                        @php
                            $isRegistered = Auth::user()->eventRegistrations()->where('event_id', $event->id)->exists();
                        @endphp
                        @if($isRegistered)
                            <span class="bg-gray-400 text-white font-bold py-3 px-6 rounded-lg text-lg">Anda Sudah Terdaftar</span>
                        @else
                            <a href="{{ route('member.events.register.create', $event->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300">
                                Daftar Event Ini
                            </a>
                        @endif
                    @else
                     {{-- Jika bukan member, mungkin tampilkan pesan lain atau tidak ada tombol daftar --}}
                     <p class="text-gray-600 mt-4">Hanya member yang dapat mendaftar event.</p>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('guest.events.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Event
        </a>
    </div>
</div>
@endsection
