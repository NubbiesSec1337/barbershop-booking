<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Barber;
use App\Models\User;
use App\Models\Booking;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create services if not exist
        if (Service::count() === 0) {
            Service::create([
                'name' => 'Potong Rambut Biasa',
                'description' => 'Potongan rambut modern dan klasik dengan hasil rapi',
                'price' => 35000,
                'duration_minutes' => 30,
                'is_active' => true
            ]);

            Service::create([
                'name' => 'Potong + Shampo',
                'description' => 'Paket lengkap potong rambut dengan keramas premium',
                'price' => 45000,
                'duration_minutes' => 45,
                'is_active' => true
            ]);

            Service::create([
                'name' => 'Creambath',
                'description' => 'Perawatan rambut lengkap dengan vitamin dan pijat',
                'price' => 65000,
                'duration_minutes' => 60,
                'is_active' => true
            ]);

            Service::create([
                'name' => 'Cat Rambut',
                'description' => 'Pewarnaan rambut dengan cat berkualitas tinggi',
                'price' => 120000,
                'duration_minutes' => 120,
                'is_active' => true
            ]);
        }

        // Create barbers if not exist
        if (Barber::count() === 0) {
            Barber::create([
                'name' => 'Budi Santoso',
                'phone' => '081234567890',
                'bio' => 'Barber senior dengan 10 tahun pengalaman di barbershop modern',
                'max_slots_per_time' => 5,
                'is_active' => true
            ]);

            Barber::create([
                'name' => 'Andi Wijaya',
                'phone' => '081234567891',
                'bio' => 'Spesialis potong modern, fade, dan undercut',
                'max_slots_per_time' => 5,
                'is_active' => true
            ]);

            Barber::create([
                'name' => 'Cahyo Pratama',
                'phone' => '081234567892',
                'bio' => 'Expert coloring dan hair styling profesional',
                'max_slots_per_time' => 3,
                'is_active' => true
            ]);
        }

        // Create customer users
        $customers = [];
        for ($i = 1; $i <= 5; $i++) {
            $customers[] = User::firstOrCreate(
                ['email' => "customer{$i}@test.com"],
                [
                    'name' => "Customer {$i}",
                    'password' => bcrypt('password'),
                    'role' => 'customer'
                ]
            );
        }

        // Get all data
        $services = Service::all();
        $barbers = Barber::all();

        // Create dummy bookings (berbagai status dan tanggal)
if ($services->count() > 0 && $barbers->count() > 0 && count($customers) > 0) {
    
    $this->command->info("🔍 DEBUG: Services={$services->count()}, Barbers={$barbers->count()}, Customers=" . count($customers));
    
    // Time slots available
    $timeSlots = [
        '09:00:00', '09:30:00', '10:00:00', '10:30:00',
        '11:00:00', '11:30:00', '13:00:00', '13:30:00',
        '14:00:00', '14:30:00', '15:00:00', '15:30:00',
        '16:00:00', '16:30:00', '17:00:00', '17:30:00',
    ];

    // Bookings for last 7 days (completed/cancelled)
    try {
        for ($day = 7; $day >= 1; $day--) {
            $bookingsPerDay = rand(2, 4);
            for ($j = 0; $j < $bookingsPerDay; $j++) {
                Booking::create([
                    'user_id' => $customers[array_rand($customers)]->id,
                    'service_id' => $services->random()->id,
                    'barber_id' => $barbers->random()->id,
                    'booking_date' => now()->subDays($day)->format('Y-m-d'),
                    'booking_time' => $timeSlots[array_rand($timeSlots)],
                    'status' => rand(0, 10) > 2 ? 'confirmed' : 'cancelled',
                    'notes' => rand(0, 2) == 0 ? 'Request potong model terbaru' : null,
                ]);
            }
        }
        $this->command->info("✅ Past bookings created");
    } catch (\Exception $e) {
        $this->command->error("❌ Error creating past bookings: " . $e->getMessage());
    }

    // Bookings for today
    try {
        for ($i = 0; $i < 5; $i++) {
            Booking::create([
                'user_id' => $customers[array_rand($customers)]->id,
                'service_id' => $services->random()->id,
                'barber_id' => $barbers->random()->id,
                'booking_date' => now()->format('Y-m-d'),
                'booking_time' => $timeSlots[array_rand($timeSlots)],
                'status' => ['pending', 'confirmed'][rand(0, 1)],
                'notes' => rand(0, 3) == 0 ? 'Datang tepat waktu ya' : null,
            ]);
        }
        $this->command->info("✅ Today bookings created");
    } catch (\Exception $e) {
        $this->command->error("❌ Error creating today bookings: " . $e->getMessage());
    }

    // Bookings for future
    try {
        for ($day = 1; $day <= 14; $day++) {
            $bookingsPerDay = rand(1, 3);
            for ($j = 0; $j < $bookingsPerDay; $j++) {
                Booking::create([
                    'user_id' => $customers[array_rand($customers)]->id,
                    'service_id' => $services->random()->id,
                    'barber_id' => $barbers->random()->id,
                    'booking_date' => now()->addDays($day)->format('Y-m-d'),
                    'booking_time' => $timeSlots[array_rand($timeSlots)],
                    'status' => 'pending',
                    'notes' => rand(0, 4) == 0 ? 'Booking untuk acara special' : null,
                ]);
            }
        }
        $this->command->info("✅ Future bookings created");
    } catch (\Exception $e) {
        $this->command->error("❌ Error creating future bookings: " . $e->getMessage());
    }
}


        $bookingCount = Booking::count();
        $this->command->info('✅ Dummy data created successfully!');
        $this->command->info("📊 Services: {$services->count()}");
        $this->command->info("💈 Barbers: {$barbers->count()}");
        $this->command->info("👥 Customers: " . count($customers));
        $this->command->info("📅 Bookings: {$bookingCount}");
    }
}
