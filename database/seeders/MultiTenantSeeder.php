<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organizer;
use App\Models\Event;
use App\Models\Category;

class MultiTenantSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Organizer 1: HIMA Informatika (HMIF)
        $userIf = User::firstOrCreate(
            ['email' => 'himaif@amikom.ac.id'],
            [
                'name' => 'Panitia HMIF',
                'password' => bcrypt('password'),
                'role' => 'organizer',
            ]
        );

        $organizerIf = Organizer::firstOrCreate(
            ['slug' => 'hima-if'],
            [
                'user_id' => $userIf->id,
                'name' => 'HIMA Informatika (HMIF)',
                'description' => 'Himpunan Mahasiswa Informatika Universitas AMIKOM Yogyakarta',
                'status' => 'approved',
            ]
        );

        Event::whereIn('id', [1, 2, 3, 4])->whereNull('organizer_id')->update([
            'organizer_id' => $organizerIf->id,
        ]);

        // 2. Organizer 2: HIMA Sistem Informasi (HIMASI)
        $userSi = User::firstOrCreate(
            ['email' => 'himasi@amikom.ac.id'],
            [
                'name' => 'Panitia HIMASI',
                'password' => bcrypt('password'),
                'role' => 'organizer',
            ]
        );

        $organizerSi = Organizer::firstOrCreate(
            ['slug' => 'hima-si'],
            [
                'user_id' => $userSi->id,
                'name' => 'HIMA Sistem Informasi (HIMASI)',
                'description' => 'Himpunan Mahasiswa Sistem Informasi Universitas AMIKOM Yogyakarta',
                'status' => 'approved',
            ]
        );

        Event::whereIn('id', [5, 6])->whereNull('organizer_id')->update([
            'organizer_id' => $organizerSi->id,
        ]);

        $catTech = Category::where('slug', 'teknologi')->first() ?? Category::first();
        if ($catTech) {
            Event::firstOrCreate(
                ['title' => 'SI Fest 2025: Information Systems Expo'],
                [
                    'category_id' => $catTech->id,
                    'organizer_id' => $organizerSi->id,
                    'description' => 'Pameran karya dan seminar nasional sistem informasi HIMA SI.',
                    'date' => '2025-04-10 09:00:00',
                    'location' => 'Auditorium Amikom',
                    'price' => 30000,
                    'stock' => 100,
                    'poster_path' => 'assets/workshop.png',
                ]
            );
        }
    }
}
