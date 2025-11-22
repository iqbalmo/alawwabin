@extends('layouts.app')

@section('title', 'Notifikasi')

@section('breadcrumbs')
    <li>
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-[#2C5F2D] transition-colors">Dashboard</a>
    </li>
    <li>
        <span class="text-gray-400 mx-2">/</span>
    </li>
    <li>
        <span class="text-gray-900 font-medium">Notifikasi</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
            <p class="mt-1 text-sm text-gray-600">Semua notifikasi Anda</p>
        </div>
        @if($notifications->where('read_at', null)->count() > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-[#2C5F2D] text-white rounded-lg hover:bg-[#234524] transition-colors text-sm font-medium">
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    {{-- Notifications List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        @forelse($notifications as $notification)
            <div class="p-4 border-b border-gray-100 last:border-b-0 {{ $notification->isUnread() ? 'bg-[#F0E6D2]/30' : '' }} hover:bg-gray-50 transition-colors">
                <div class="flex items-start gap-4">
                    {{-- Icon --}}
                    <div class="flex-shrink-0 mt-1">
                        @if($notification->isUnread())
                            <div class="h-3 w-3 rounded-full bg-[#C8963E]"></div>
                        @else
                            <div class="h-3 w-3 rounded-full bg-gray-300"></div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-900">{{ $notification->title }}</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $notification->message }}</p>
                                <p class="mt-2 text-xs text-gray-400">{{ $notification->time_ago }}</p>
                            </div>

                            {{-- Mark as Read Button --}}
                            @if($notification->isUnread())
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs text-[#2C5F2D] hover:text-[#C8963E] font-medium whitespace-nowrap">
                                        Tandai Dibaca
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h3 class="mt-4 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                <p class="mt-1 text-sm text-gray-500">Anda belum memiliki notifikasi</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
