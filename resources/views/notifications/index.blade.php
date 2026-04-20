@extends('layouts.app')

@section('content')
    <style>
        .notifications-page {
            min-height: 100%;
            display: grid;
            place-items: start center;
            padding: 18px 0 10px;
        }

        .notifications-shell {
            width: min(460px, 100%);
            background: linear-gradient(180deg, #ffffff 0%, #fffefe 100%);
            border-radius: 22px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
        }

        .notifications-header {
            display: grid;
            grid-template-columns: 28px 1fr 28px;
            align-items: center;
            padding: 16px 18px;
            border-bottom: 1px solid #edf2f7;
            background: #ffffff;
        }

        .header-icon {
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            color: #38bdf8;
            font-size: 18px;
        }

        .notifications-title {
            margin: 0;
            text-align: center;
            font-size: 16px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.02em;
        }

        .header-action {
            justify-self: end;
            width: 28px;
            height: 28px;
            border-radius: 999px;
            border: 1px solid #dbe3ea;
            color: #94a3b8;
            display: grid;
            place-items: center;
            font-size: 13px;
            text-decoration: none;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .header-action:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        .notifications-list {
            padding: 8px 0;
        }

        .notification-item {
            display: grid;
            grid-template-columns: 52px 1fr 40px;
            gap: 12px;
            padding: 14px 18px;
            align-items: start;
            border-left: 4px solid transparent;
            transition: background-color 0.2s ease;
        }

        .notification-item+.notification-item {
            border-top: 1px solid #f3f4f6;
        }

        .notification-item.unread {
            background: #f8fafc;
            border-left-color: #38bdf8;
        }

        .avatar {
            width: 52px;
            height: 52px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            overflow: hidden;
            background: linear-gradient(135deg, #dbeafe 0%, #bae6fd 100%);
            color: #0369a1;
            font-weight: 800;
            font-size: 16px;
            flex-shrink: 0;
        }

        .avatar.avatar-alt {
            background: linear-gradient(135deg, #e9d5ff 0%, #c4b5fd 100%);
            color: #6d28d9;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .notification-content {
            min-width: 0;
        }

        .notification-name {
            margin: 0;
            font-size: 14px;
            font-weight: 800;
            color: #0ea5e9;
            line-height: 1.2;
        }

        .notification-subtitle {
            margin: 2px 0 6px;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.35;
        }

        .notification-message {
            margin: 0;
            color: #334155;
            font-size: 13px;
            line-height: 1.45;
        }

        .notification-time {
            color: #cbd5e1;
            font-size: 11px;
            text-align: right;
            white-space: nowrap;
            padding-top: 3px;
        }

        .notification-actions {
            margin-top: 8px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .notification-actions .btn {
            width: auto;
            text-decoration: none;
            padding: 8px 12px;
            font-size: 13px;
            border-radius: 10px;
        }

        .btn-secondary {
            background: #ffffff;
            color: #0f172a;
            border: 1px solid #dbe3ea;
            box-shadow: none;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            transform: none;
            box-shadow: none;
        }

        .notifications-footer {
            padding: 14px 18px 18px;
            text-align: center;
            border-top: 1px solid #f1f5f9;
        }

        .footer-link {
            color: #38bdf8;
            font-weight: 700;
            text-decoration: none;
            font-size: 13px;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        .empty-state {
            padding: 24px 18px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }
    </style>

    <div class="notifications-page">
        <div class="notifications-shell">
            <div class="notifications-header">
                <div class="header-icon">🔔</div>
                <h1 class="notifications-title">Notifications</h1>
                <a class="header-action" href="{{ route('dashboard') }}" aria-label="Close notifications">×</a>
            </div>

            <div class="notifications-list">
                @forelse ($notifications as $notification)
                    @php
                        $isUnread = !$notification->is_read;
                        $avatarLetter = strtoupper(substr($notification->user?->name ?? 'N', 0, 1));
                    @endphp

                    <div class="notification-item {{ $isUnread ? 'unread' : '' }}">
                        <div class="avatar {{ $loop->even ? 'avatar-alt' : '' }}">
                            {{ $avatarLetter }}
                        </div>

                        <div class="notification-content">
                            <p class="notification-name">{{ $notification->user?->name ?? 'Notification' }}</p>
                            <p class="notification-subtitle">
                                @if ($notification->signalement)
                                    Signalement #{{ $notification->signalement->id }}
                                @else
                                    Latest activity
                                @endif
                            </p>
                            <p class="notification-message">{{ $notification->message }}</p>

                            <div class="notification-actions">
                                @if ($notification->signalement)
                                    <a class="btn btn-secondary"
                                        href="{{ route('signalements.show', $notification->signalement) }}">
                                        Open
                                    </a>
                                @endif

                                @if ($isUnread)
                                    <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn">Mark read</button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="notification-time">
                            {{ $notification->created_at?->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="empty-state">No notifications yet.</div>
                @endforelse
            </div>

            <div class="notifications-footer">
                <a class="footer-link" href="{{ route('dashboard') }}">See all incoming activity</a>
            </div>
        </div>

        <div style="margin-top: 16px; width: min(460px, 100%);">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
