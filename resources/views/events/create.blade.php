<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sự kiện</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <a href="{{ route('events.index') }}" class="btn btn-secondary mb-4">
        ← Back
    </a>

    <div class="card shadow">
        <div class="card-header">
            <h3 class="mb-0">➕ Thêm sự kiện</h3>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('events.store') }}">
                @csrf

                {{-- Tên sự kiện --}}
                <div class="mb-3">
                    <label class="form-label">Tên sự kiện</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                {{-- Mô tả --}}
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>

                {{-- Địa điểm --}}
                <div class="mb-3">
                    <label class="form-label">Địa điểm</label>
                    <input type="text" name="location" class="form-control">
                </div>

                {{-- Ngày bắt đầu --}}
                <div class="mb-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="datetime-local" name="start_time" class="form-control">
                </div>

                {{-- Ngày kết thúc --}}
                <div class="mb-3">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="datetime-local" name="end_time" class="form-control">
                </div>

                {{-- Sức chứa --}}
                <div class="mb-3">
                    <label class="form-label">Sức chứa</label>
                    <input type="number" name="capacity" class="form-control">
                </div>

                {{-- Danh mục --}}
                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tags --}}
                <div class="mb-3">
                    <label class="form-label">Tags</label>

                    <div class="row">
                        @foreach($tags as $tag)
                            <div class="col-md-3">
                                <label>
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    ➕ Thêm
                </button>

            </form>

        </div>
    </div>

</div>

</body>
</html>