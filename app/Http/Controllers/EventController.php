<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
<<<<<<< HEAD
        $this->middleware('auth')->except(['index', 'show']);
    }

    /* ======================
        INDEX
    ====================== */
    public function index(Request $request)
    {
        $events = Event::query()
            ->where('status', 'published')
            ->with(['category', 'tags', 'registrations.user', 'organizer'])
            ->when($request->category, fn($q) =>
                $q->where('category_id', $request->category)
            )
            ->when($request->search, fn($q) =>
                $q->where('title', 'like', "%{$request->search}%")
            )
            ->when($request->date, fn($q) =>
                $q->whereDate('start_time', $request->date)
            )
            ->latest()
            ->paginate(12);
=======
        $events = Event::with(['tags', 'category', 'user'])
    ->latest()
    ->get();
>>>>>>> 651e64641248d7cad8cdf1914662b3b41735add4

        return view('events.index', compact('events'));
    }

    /* ======================
        SHOW (FIX FULL)
    ====================== */
    public function show(Event $event)
    {
        $event->load(['category', 'tags', 'registrations.user', 'organizer']);

        $isRegistered = false;

        if (auth()->check()) {
            $isRegistered = $event->registrations
                ->where('user_id', auth()->id())
                ->isNotEmpty();
        }

        return view('events.show', compact('event', 'isRegistered'));
    }

    /* ======================
        CREATE
    ====================== */
    public function create()
    {
        $this->authorize('create', Event::class);

        return view('events.create', [
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    /* ======================
        STORE
    ====================== */
    public function store(EventRequest $request)
    {
        $event = Event::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        $event->tags()->sync($request->tags ?? []);

        return redirect()
            ->route('events.index')
            ->with('success', 'Tạo sự kiện thành công');
    }

    /* ======================
        EDIT
    ====================== */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('events.edit', [
            'event' => $event,
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    /* ======================
        UPDATE
    ====================== */
    public function update(EventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $event->update($request->validated());
        $event->tags()->sync($request->tags ?? []);

        return redirect()
            ->route('events.index')
            ->with('success', 'Cập nhật sự kiện thành công');
    }

    /* ======================
        DELETE
    ====================== */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Xóa sự kiện thành công');
    }

    /* ======================
        REGISTER
    ====================== */
    public function register(Event $event)
    {
        abort_unless(auth()->check(), 403);

        if ($event->registrations()
            ->where('user_id', auth()->id())
            ->exists()) {
            return back()->with('error', 'Bạn đã đăng ký rồi');
        }

        if ($event->registrations()->count() >= $event->capacity) {
            return back()->with('error', 'Sự kiện đã đầy chỗ');
        }

        $event->registrations()->create([
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Đăng ký thành công');
    }

    /* ======================
        UNREGISTER
    ====================== */
    public function unregister(Event $event)
    {
        abort_unless(auth()->check(), 403);

        $event->registrations()
            ->where('user_id', auth()->id())
            ->delete();

        return back()->with('success', 'Hủy đăng ký thành công');
    }
}