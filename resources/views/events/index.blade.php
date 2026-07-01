<!DOCTYPE html>
<html>
<head>
    <title>Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">📅 Danh sách Events</h2>
    @can('create', App\Models\Event::class)
<div class="mb-3">
    <a href="{{ route('events.create') }}" class="btn btn-success">
        + Create Event
    </a>
</div>
@endcan
    <!-- FILTER BAR -->
<form method="GET" action="{{ route('events.index') }}" class="row g-2 mb-4">

    <!-- SEARCH -->
    <div class="col-md-4">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="🔍 Search title..."
            value="{{ request('search') }}"
        >
    </div>

    <!-- CATEGORY -->
    <div class="col-md-3">
        <select name="category" class="form-select">
            <option value="">📂 All Categories</option>
            @foreach(\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}"
                    {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    

    <!-- DATE -->
    <div class="col-md-3">
        <input
            type="date"
            name="date"
            class="form-control"
            value="{{ request('date') }}"
        >
    </div>

    <!-- BUTTON -->
    <div class="col-md-2">
        <button class="btn btn-primary w-100" type="submit">
            Search
        </button>
    </div>

</form>
<a href="{{ route('events.index') }}" class="btn btn-secondary mb-3">
    Reset Filter
</a>
    <div class="row">

        @foreach($events as $event)
            <div class="col-md-4 mb-3">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <h5 class="card-title">
                            {{ $event->title }}
                        </h5>

                        <p class="text-muted">
                            📍 {{ $event->location }}
                        </p>
                        <p class="small">
                            📅 {{ $event->start_time }} → {{ $event->end_time }}
                        </p>

                        <p>
                            👥 {{ $event->registrations->count() }} / {{ $event->capacity }} người
                        </p>

                        <p>
                            🏷
                            @foreach($event->tags as $tag)
                                <span class="badge bg-primary">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </p>
                        <p class="small">
                            📂 {{ $event->category->name ?? 'No category' }}
</p>
                        <p class="small">
                            👤 {{ $event->organizer->name ?? 'Unknown' }}
                        </p>
                        <p class="text-muted small">
                            📝{{ \Illuminate\Support\Str::limit($event->description, 100) }}
                             
                        </p>


                        <span class="badge bg-{{ $event->status === 'published' ? 'success' : 'secondary' }}">
                            {{ ucfirst($event->status) }}
                        </span>
                        <div class="mt-3">

    <a href="{{ route('events.show', $event) }}"
       class="btn btn-outline-primary w-100">

        View Details

    </a>

</div>
                        
                    </div>

                </div>

            </div>
        @endforeach

    </div>
    

<div class="d-flex justify-content-center mt-4">
    {{ $events->withQueryString()->links('pagination::bootstrap-5') }}
</div>

</div>

</body>
</html>
