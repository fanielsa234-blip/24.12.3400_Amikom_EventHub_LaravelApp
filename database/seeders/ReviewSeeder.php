<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $sampleUser = User::firstOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );

        $sampleTransaction = Transaction::firstOrCreate(
            ['order_id' => 'TRX-SAMPLE-001'],
            [
                'event_id' => 1,
                'customer_name' => 'Budi Santoso',
                'customer_email' => 'budi@gmail.com',
                'customer_phone' => '081234567890',
                'total_price' => 155000,
                'status' => 'success',
            ]
        );

        Review::firstOrCreate(
            ['user_id' => $sampleUser->id, 'event_id' => 1],
            [
                'transaction_id' => $sampleTransaction->id,
                'rating' => 5,
                'comment' => 'Acara luar biasa! Sound system mantap dan alunan musik jazz-nya sangat memukau.',
            ]
        );
    }
}
