<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Barber;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // SERVICES - CREATE SATU SATU
        Service::create([
            'name' => 'Potong Rambut Biasa',
            'price' => 35000,
            'duration_minutes' => 30
        ]);
        
        Service::create([
            'name' => 'Potong + Shampo',
            'price' => 45000,
            'duration_minutes' => 45
        ]);
        
        Service::create([
            'name' => 'Creambath',
            'price' => 65000,
            'duration_minutes' => 60
        ]);
        
        Service::create([
            'name' => 'Cat Rambut',
            'price' => 120000,
            'duration_minutes' => 120
        ]);

        // BARBERS
        Barber::create([
            'name' => 'Andi Santoso',
            'bio' => 'Spesialis potong modern & anak-anak. Teliti dan sabar.',
            'max_slots_per_time' => 1
        ]);

        Barber::create([
            'name' => 'Budi Hartono',
            'bio' => 'Expert creambath premium & treatment kulit kepala.',
            'max_slots_per_time' => 1
        ]);

        Barber::create([
            'name' => 'Citra Dewi',
            'bio' => 'Styling wanita, coloring & blow dry profesional.',
            'max_slots_per_time' => 1
        ]);

        Barber::create([
            'name' => 'Doni Pratama',
            'bio' => 'Potong cepat presisi untuk pria aktif.',
            'max_slots_per_time' => 2
        ]);
    }
}
