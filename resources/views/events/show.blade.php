<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $event->title }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <a href="{{ route('events.index') }}" class="btn btn-secondary mb-4">
        ← Back to Events
    </a>

    <div class="card shadow">
        <div class="card-body">

            <h2 class="mb-3">{{ $event->title }}</h2>

            <span class="badge bg-success mb-3">
                {{ ucfirst($event->status) }}
            </span>

            <hr>

            <p><strong>📍 Location:</strong> {{ $event->location }}</p>
            <p><strong>📅 Start:</strong> {{ $event->start_time }}</p>
            <p><strong>📅 End:</strong> {{ $event->end_time }}</p>
            <p><strong>👥 Capacity:</strong> {{ $event->capacity }}</p>

            <p>
                <strong>📂 Category:</strong>
                {{ $event->category->name ?? 'No Category' }}
            </p>

            <p>
                <strong>👤 Organizer:</strong>
                {{ $event->organizer->name ?? 'Unknown' }}
            </p>

            @php
                $registrations = $event->registrations ?? collect();
                $currentSlots = $registrations->count();
                $isFull = $currentSlots >= $event->capacity;

                $isRegistered = auth()->check()
                    ? $registrations->contains('user_id', auth()->id())
                    : false;
            @endphp

            <p>
                <strong>📊 Slots:</strong>
                {{ $currentSlots }} / {{ $event->capacity }}
            </p>

            @if($isFull)
                <div class="alert alert-danger">
                    🔴 Sự kiện đã đầy chỗ
                </div>
            @endif

            <p>
                <strong>🏷 Tags:</strong>
                @foreach($event->tags as $tag)
                    <span class="badge bg-primary">{{ $tag->name }}</span>
                @endforeach
            </p>

            <hr>

            {{-- ACTION BUTTONS (EDIT / DELETE) --}}
           @can('update', $event)
    <div class="mb-3">

        <a href="{{ route('events.edit', $event->id) }}"
           class="btn btn-warning">
            ✏️ Edit Event
        </a>

        <form method="POST"
      action="{{ route('events.destroy', $event->id) }}"
      style="display:inline-block"
      onsubmit="return confirm('Bạn có chắc muốn xóa sự kiện này không?')">

    @csrf
    @method('DELETE')

    <button class="btn btn-danger">
        Delete
    </button>
</form>

    </div>
@endcan

            <h4>Description</h4>
            <p>{{ $event->description }}</p>

        </div>
    </div>

    {{-- REGISTERED USERS --}}
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">👥 Registered Users</h4>
        </div>

        <div class="card-body">

            @forelse($registrations as $registration)
                <div class="border rounded p-3 mb-3">
                    <strong>{{ $registration->user->name ?? 'Unknown' }}</strong>
                    <br>
                    <small class="text-muted">
                        {{ $registration->user->email ?? '' }}
                    </small>
                </div>
            @empty
                <div class="alert alert-warning mb-0">
                    Chưa có người đăng ký.
                </div>
            @endforelse

        </div>
    </div>

    {{-- REGISTER LOGIC --}}
    <div class="mt-3">

        @if($isFull && !$isRegistered)
            <div class="alert alert-danger">
                🔴 Sự kiện đã đủ chỗ đăng ký
            </div>

        @elseif($isRegistered)
            <div class="alert alert-info">
                Bạn đã đăng ký sự kiện
            </div>

            <form method="POST" action="{{ route('events.unregister', $event->id) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    Hủy đăng ký
                </button>
            </form>

        @else
            @auth
                <form method="POST" action="{{ route('events.register', $event->id) }}">
                    @csrf
                    <button class="btn btn-success">
                        Đăng ký
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    Đăng nhập để đăng ký
                </a>
            @endauth
        @endif

    </div>

</div>

</body>
</html>