<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ======================
        // 1. USERS
        // ======================

        User::factory()->count(3)->create([
            'role' => 'admin',
        ]);

        User::factory()->count(10)->create([
            'role' => 'organizer',
        ]);

        User::factory()->count(50)->create([
            'role' => 'student',
        ]);

        // ======================
        // 2. CATEGORIES
        // ======================

        $categories = [
            'Công nghệ',
            'Học thuật',
            'Cuộc thi',
            'Workshop',
            'Seminar',
            'Nghiên cứu',
            'Kỹ năng mềm',
            'Khởi nghiệp'
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $name
            ]);
        }

        // ======================
        // 3. TAGS
        // ======================

        $tags = [
            'AI',
            'Web',
            'Laravel',
            'React',
            'NodeJS',
            'Cloud',
            'Database',
            'Security'
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag)
            ]);
        }

        // ======================
        // 4. EVENTS
        // ======================

        $titles = [
            'Ngày hội việc làm IT 2024',
            'Hội thảo AI & Machine Learning',
            'Cuộc thi lập trình Hackathon',
            'Workshop Laravel từ A-Z',
            'Ngày hội sinh viên nghiên cứu khoa học',
            'Seminar Công nghệ Web hiện đại',
            'Tech Talk DevOps & Cloud',
            'Hội thảo Blockchain ứng dụng'
        ];

        $locations = [
            'Hội trường A',
            'Phòng máy B2',
            'Sân campus',
            'Thư viện trung tâm',
            'Phòng hội thảo D1'
        ];

        $organizers = User::where('role', 'organizer')->pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();
        $tagIds = Tag::pluck('id')->toArray();

        for ($i = 0; $i < 60; $i++) {

            $start = now()->addDays(rand(1, 90));
            $end = (clone $start)->addHours(rand(2, 8));

            $event = Event::create([
                'title' => $titles[array_rand($titles)],
                'description' => fake()->paragraphs(3, true),
                'location' => $locations[array_rand($locations)],
                'start_time' => $start,
'end_time' => $end,
                'capacity' => [30, 50, 100, 200][array_rand([30, 50, 100, 200])],
                'status' => rand(1, 10) <= 7 ? 'published' : 'draft',
                'user_id' => $organizers[array_rand($organizers)],
                'category_id' => $categories[array_rand($categories)],
            ]);

            // attach 2-4 tags
            shuffle($tagIds);
            $event->tags()->attach(array_slice($tagIds, 0, rand(2, 4)));
        }
    }
    
}