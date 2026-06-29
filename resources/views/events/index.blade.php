<!DOCTYPE html>
<html>
<head>
    <title>Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">📅 Danh sách Events</h2>

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
                            👥 {{ $event->capacity }} người
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
                            👤 {{ $event->user->name ?? 'Unknown' }}
                        </p>
                        <p class="text-muted small">
                            📝 {{ Str::limit($event->description, 100) }}
                        </p>


                        <span class="badge bg-{{ $event->status == 'published' ? 'success' : 'secondary' }}">
                            {{ $event->status }}
                        </span>
                        
                    </div>

                </div>

            </div>
        @endforeach

    </div>

</div>

</body>
</html>