<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Partner;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Superadmin Utama
        User::firstOrCreate(
            ['email' => 'admin@amikom.ac.id'],
            [
                'name' => 'Admin Amikom',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // 2. Insert 3 Kategori (Musik, Teknologi, Workshop)
        $catMusik = Category::firstOrCreate(['slug' => 'musik'], ['name' => 'Musik']);
        $catTech = Category::firstOrCreate(['slug' => 'teknologi'], ['name' => 'Teknologi']);
        $catWorkshop = Category::firstOrCreate(['slug' => 'workshop'], ['name' => 'Workshop & Seminar']);

        // 3. Insert Sampel Events
        Event::firstOrCreate(
            ['title' => 'Jazz Night 2024: A Celebration'],
            [
                'category_id' => $catMusik->id,
                'description' => 'Nikmati malam yang indah dengan alunan musik Jazz dari musisi internasional. Acara ini juga dilengkapi dengan food stall premium.',
                'date' => '2024-11-16 19:30:00',
                'location' => 'The Blue Note Lounge, Metropolis',
                'price' => 150000,
                'stock' => 100,
                'poster_path' => 'assets/concert.png',
            ]
        );

        Event::firstOrCreate(
            ['title' => 'AI & Future: Unleash The Power'],
            [
                'category_id' => $catTech->id,
                'description' => 'Jelajahi tren terkini dalam bidang Artificial Intelligence bersama pakar industri dari berbagai perusahaan teknologi top dunia.',
                'date' => '2024-10-26 09:00:00',
                'location' => 'Innovation Hub, London',
                'price' => 50000,
                'stock' => 50,
                'poster_path' => 'assets/workshop.png',
            ]
        );

        Event::firstOrCreate(
            ['title' => 'Hackathon 2024: Ultimate Marathon'],
            [
                'category_id' => $catTech->id,
                'description' => 'Tunjukkan kemampuan coding-mu dalam ajang kompetisi programming non-stop selama 48 jam.',
                'date' => '2024-10-18 08:00:00',
                'location' => 'City Innovation Hub',
                'price' => 0,
                'stock' => 200,
                'poster_path' => 'assets/hackathon.png',
            ]
        );

        Event::firstOrCreate(
            ['title' => 'UI/UX Masterclass for Beginner'],
            [
                'category_id' => $catWorkshop->id,
                'description' => 'Belajar merancang antarmuka aplikasi yang user-friendly dari nol bersama UI/UX Designer profesional.',
                'date' => '2025-01-15 13:00:00',
                'location' => 'Gedung Cinema Amikom',
                'price' => 45000,
                'stock' => 120,
                'poster_path' => 'assets/workshop.png',
            ]
        );

        Event::firstOrCreate(
            ['title' => 'Seminar Technopreneur'],
            [
                'category_id' => $catWorkshop->id,
                'description' => 'Membangun bisnis rintisan (Startup) dari ide hingga mendapatkan pendanaan.',
                'date' => '2025-02-20 09:00:00',
                'location' => 'Ruang Citra 1',
                'price' => 35000,
                'stock' => 150,
                'poster_path' => 'assets/workshop.png',
            ]
        );

        Event::firstOrCreate(
            ['title' => 'E-Sport U-Champ Tournament'],
            [
                'category_id' => $catTech->id,
                'description' => 'Turnamen E-Sport antar Universitas se-Yogyakarta dengan total hadiah puluhan juta rupiah.',
                'date' => '2025-03-05 10:00:00',
                'location' => 'Gor Amikom',
                'price' => 25000,
                'stock' => 300,
                'poster_path' => 'assets/hackathon.png',
            ]
        );

        // 4. Partner Samples
        for ($i = 1; $i <= 4; $i++) {
            Partner::firstOrCreate(
                ['name' => "Partner Resmi #$i"],
                ['logo_url' => "https://placehold.co/200x200?text=Partner+$i"]
            );
        }

        // 5. MultiTenantSeeder
        $this->call(MultiTenantSeeder::class);
    }
}
