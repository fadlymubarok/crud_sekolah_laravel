<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'username' => 'fadlymbrk',
            'password' => Hash::make('12345678'),
            'guru_id' => 1,
            'is_admin' => 1
        ]);

        Guru::create([
            'nama_guru' => 'Fadly Mubarok',
            'tanggal_lahir_guru' => Carbon::parse('08-04-2004'),
            'alamat_guru' => 'Bekasi',
            'status_aktif' => 1,
        ]);
    }
}
