<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 2. Insert 3 Kategori (Syarat Latihan 4.5)
        $catMusik = Category::create(['name' => 'Musik', 'slug' => 'musik']);
        $catTech = Category::create(['name' => 'Teknologi', 'slug' => 'teknologi']);
        $catWorkshop = Category::create(['name' => 'Workshop & Seminar', 'slug' => 'workshop']);

        // 3. Insert 6 Sampel Events (Syarat Latihan 4.5)
        // Event 1 (Sesuai Template)
        Event::create([
            'category_id' => $catMusik->id,
            'title' => 'Jazz Night 2024: A Celebration',
            'description' => 'Nikmati malam yang indah dengan alunan musik Jazz dari musisi internasional. Acara ini juga dilengkapi dengan food stall premium.',
            'date' => '2024-11-16 19:30:00',
            'location' => 'The Blue Note Lounge, Metropolis',
            'price' => 150000,
            'stock' => 100,
            'poster_path' => 'assets/concert.png',
        ]);

        // Event 2 (Sesuai Template)
        Event::create([
            'category_id' => $catTech->id,
            'title' => 'AI & Future: Unleash The Power',
            'description' => 'Jelajahi tren terkini dalam bidang Artificial Intelligence bersama pakar industri dari berbagai perusahaan teknologi top dunia.',
            'date' => '2024-10-26 09:00:00',
            'location' => 'Innovation Hub, London',
            'price' => 50000,
            'stock' => 50,
            'poster_path' => 'assets/workshop.png',
        ]);

        // Event 3 (Sesuai Template)
        Event::create([
            'category_id' => $catTech->id,
            'title' => 'Hackathon 2024: Ultimate Marathon',
            'description' => 'Tunjukkan kemampuan coding-mu dalam ajang kompetisi programming non-stop selama 48 jam.',
            'date' => '2024-10-18 08:00:00',
            'location' => 'City Innovation Hub',
            'price' => 0,
            'stock' => 200,
            'poster_path' => 'assets/hackathon.png',
        ]);

        // Event 4
        Event::create([
            'category_id' => $catWorkshop->id,
            'title' => 'UI/UX Masterclass for Beginner',
            'description' => 'Belajar merancang antarmuka aplikasi yang user-friendly dari nol bersama UI/UX Designer profesional.',
            'date' => '2025-01-15 13:00:00',
            'location' => 'Gedung Cinema Amikom',
            'price' => 45000,
            'stock' => 120,
            'poster_path' => 'assets/workshop.png',
        ]);

        // Event 5
        Event::create([
            'category_id' => $catWorkshop->id,
            'title' => 'Seminar Technopreneur',
            'description' => 'Membangun bisnis rintisan (Startup) dari ide hingga mendapatkan pendanaan.',
            'date' => '2025-02-20 09:00:00',
            'location' => 'Ruang Citra 1',
            'price' => 35000,
            'stock' => 150,
            'poster_path' => 'assets/workshop.png',
        ]);

        // Event 6
        Event::create([
            'category_id' => $catTech->id,
            'title' => 'E-Sport U-Champ Tournament',
            'description' => 'Turnamen E-Sport antar Universitas se-Yogyakarta dengan total hadiah puluhan juta rupiah.',
            'date' => '2025-03-05 10:00:00',
            'location' => 'Gor Amikom',
            'price' => 25000,
            'stock' => 300,
            'poster_path' => 'assets/hackathon.png',
        ]);
    }
}
