@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>🔔 Notifications</h2>
        @if(auth()->user()->unreadNotifications() > 0)
            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm">Mark All as Read</button>
            </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="empty-state">
            <i class="fas fa-bell empty-icon"></i>
            <h4>No Notifications</h4>
            <p>You're all caught up!</p>
        </div>
    @else
        @foreach($notifications as $notification)
            <div class="card shadow mb-3 {{ !$notification->is_read ? 'border-start border-4 border-primary' : '' }}">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        @if($notification->type == 'dispute')
                            <i class="fas fa-exclamation-triangle text-danger" style="font-size: 24px;"></i>
                        @elseif($notification->type == 'review')
                            <i class="fas fa-star text-warning" style="font-size: 24px;"></i>
                        @elseif($notification->type == 'order')
                            <i class="fas fa-shopping-cart text-primary" style="font-size: 24px;"></i>
                        @else
                            <i class="fas fa-bell text-secondary" style="font-size: 24px;"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 {{ !$notification->is_read ? 'fw-bold' : '' }}">{{ $notification->title }}</h6>
                        <p class="mb-0 text-muted small">{{ $notification->message }}</p>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    @if(!$notification->is_read)
                        <form action="{{ route('notifications.markRead', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Mark Read</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
        
        <div class="d-flex justify-content-center">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection