<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed user table
        DB::table('user')->insert([
            [
                'id_user'    => 1,
                'nama_user'  => 'admin jjenaissante',
                'no_hp'      => null,
                'email'      => 'admin@gmail.com',
                'password'   => '$2y$10$8L/f98TB0SHkrM7dh1vcluNH/08hjUm6jjFuy5xo7DVtCPR70nhpC',
                'role'       => 'admin',
                'created_at' => '2026-01-06 12:33:09',
                'updated_at' => '2026-01-08 13:49:11',
            ],
            [
                'id_user'    => 2,
                'nama_user'  => 'Admin Jena',
                'no_hp'      => null,
                'email'      => 'admin@email.com',
                'password'   => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'role'       => 'admin',
                'created_at' => '2026-01-06 08:58:07',
                'updated_at' => '2026-01-08 13:49:31',
            ],
            [
                'id_user'    => 3,
                'nama_user'  => 'Mba jena',
                'no_hp'      => null,
                'email'      => 'user@email.com',
                'password'   => '$2y$10$8L/f98TB0SHkrM7dh1vcluNH/08hjUm6jjFuy5xo7DVtCPR70nhpC',
                'role'       => 'user',
                'created_at' => '2026-01-06 08:58:07',
                'updated_at' => '2026-01-08 13:50:59',
            ]
        ]);

        // 2. Seed admin table
        DB::table('admin')->insert([
            [
                'id_admin'   => 1,
                'nama_admin' => 'admin jjenaissante',
                'username'   => 'admin@gmail.com',
                'password'   => '$2y$10$8L/f98TB0SHkrM7dh1vcluNH/08hjUm6jjFuy5xo7DVtCPR70nhpC',
                'created_at' => '2026-01-06 08:58:07',
                'updated_at' => '2026-01-08 14:02:56',
            ]
        ]);

        // 3. Seed studio table
        DB::table('studio')->insert([
            [
                'id_studio'   => 'S001',
                'nama_studio' => 'STUDIO SOUNDWAVE',
                'alamat'      => 'Jl. Aji Stone 45',
                'no_telp'     => '+62 831-8258-6472',
                'email'       => 'info@studiomusik.com',
                'jam_buka'    => '08:00:00',
                'jam_tutup'   => '22:00:00',
                'created_at'  => '2026-01-06 08:40:51',
                'updated_at'  => '2026-01-08 13:57:00',
            ],
            [
                'id_studio'   => 'S002',
                'nama_studio' => 'STUDIO HARMONI',
                'alamat'      => 'Jl. Aji Stone 45',
                'no_telp'     => '+62 812-3456-7890',
                'email'       => 'info@studiomusik.com',
                'jam_buka'    => '09:00:00',
                'jam_tutup'   => '21:00:00',
                'created_at'  => '2026-01-06 08:40:51',
                'updated_at'  => '2026-01-08 13:58:47',
            ],
            [
                'id_studio'   => 'S003',
                'nama_studio' => 'STUDIO MELODI',
                'alamat'      => 'Jl. Aji Stone 45',
                'no_telp'     => '+62 813-4567-8901',
                'email'       => 'info@studiomusik.com',
                'jam_buka'    => '08:00:00',
                'jam_tutup'   => '23:00:00',
                'created_at'  => '2026-01-06 08:40:51',
                'updated_at'  => '2026-01-08 13:58:09',
            ]
        ]);

        // 4. Seed ruangan table
        DB::table('ruangan')->insert([
            [
                'id_ruangan'    => 'R001',
                'id_studio'     => 'S001',
                'nama_ruangan'  => 'Recording Studio A',
                'kapasitas'     => 5,
                'tarif_per_jam' => 150000.00,
                'fasilitas'     => 'Mixer 16 Channel, Microphone, Monitor Speaker, Headphone, AC',
                'deskripsi'     => 'Studio rekaman profesional dengan peralatan lengkap',
                'status'        => 'available',
                'created_at'    => '2026-01-06 08:40:51',
                'updated_at'    => '2026-01-06 08:40:51',
            ],
            [
                'id_ruangan'    => 'R002',
                'id_studio'     => 'S001',
                'nama_ruangan'  => 'Practice Room B',
                'kapasitas'     => 8,
                'tarif_per_jam' => 100000.00,
                'fasilitas'     => 'Guitar Amplifier, Bass Amplifier, Drum Set, Keyboard, AC',
                'deskripsi'     => 'Ruang latihan untuk band dengan peralatan lengkap',
                'status'        => 'available',
                'created_at'    => '2026-01-06 08:40:51',
                'updated_at'    => '2026-01-06 08:40:51',
            ],
            [
                'id_ruangan'    => 'R003',
                'id_studio'     => 'S001',
                'nama_ruangan'  => 'Vocal Booth C',
                'kapasitas'     => 3,
                'tarif_per_jam' => 80000.00,
                'fasilitas'     => 'Microphone Condenser, Headphone, Monitor, AC',
                'deskripsi'     => 'Booth rekaman vokal dengan isolasi suara',
                'status'        => 'available',
                'created_at'    => '2026-01-06 08:40:51',
                'updated_at'    => '2026-01-06 08:40:51',
            ],
            [
                'id_ruangan'    => 'R004',
                'id_studio'     => 'S002',
                'nama_ruangan'  => 'Recording Studio Premium',
                'kapasitas'     => 6,
                'tarif_per_jam' => 200000.00,
                'fasilitas'     => 'Mixer 24 Channel, Professional Microphone, Studio Monitor, AC',
                'deskripsi'     => 'Studio premium dengan peralatan profesional',
                'status'        => 'available',
                'created_at'    => '2026-01-06 08:40:51',
                'updated_at'    => '2026-01-06 08:40:51',
            ],
            [
                'id_ruangan'    => 'R005',
                'id_studio'     => 'S002',
                'nama_ruangan'  => 'Practice Room Standard',
                'kapasitas'     => 6,
                'tarif_per_jam' => 120000.00,
                'fasilitas'     => 'Guitar Amp, Bass Amp, Drum Set, AC',
                'deskripsi'     => 'Ruang latihan standar untuk band',
                'status'        => 'available',
                'created_at'    => '2026-01-06 08:40:51',
                'updated_at'    => '2026-01-06 08:40:51',
            ],
            [
                'id_ruangan'    => 'R006',
                'id_studio'     => 'S003',
                'nama_ruangan'  => 'Recording Studio Elite',
                'kapasitas'     => 8,
                'tarif_per_jam' => 250000.00,
                'fasilitas'     => 'Digital Mixer, Professional Equipment, Soundproof, AC',
                'deskripsi'     => 'Studio elite dengan fasilitas terbaik',
                'status'        => 'available',
                'created_at'    => '2026-01-06 08:40:51',
                'updated_at'    => '2026-01-06 08:40:51',
            ],
            [
                'id_ruangan'    => 'R007',
                'id_studio'     => 'S003',
                'nama_ruangan'  => 'Practice Room Mini',
                'kapasitas'     => 4,
                'tarif_per_jam' => 75000.00,
                'fasilitas'     => 'Mini Amplifier, Electric Drum, Keyboard, AC',
                'deskripsi'     => 'Ruang latihan mini untuk grup kecil',
                'status'        => 'available',
                'created_at'    => '2026-01-06 08:40:51',
                'updated_at'    => '2026-01-06 08:40:51',
            ]
        ]);

        // 5. Seed ulasan table
        DB::table('ulasan')->insert([
            ['id_ulasan' => 1, 'id_user' => 3, 'id_studio' => 'S001', 'rating' => 5],
            ['id_ulasan' => 2, 'id_user' => 3, 'id_studio' => 'S001', 'rating' => 5],
            ['id_ulasan' => 3, 'id_user' => 3, 'id_studio' => 'S001', 'rating' => 5],
        ]);
    }
}
