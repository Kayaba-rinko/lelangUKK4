<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMasyarakat = [
            [
                'name' => 'Masyarakat ',
                'username' => 'Masayarakat',
                'telp' => '081234567890',
                'status' => 'aktif',
                'password' => '123456789',
            ],
        ];
        foreach ($dataMasyarakat as $item) {
            \App\Models\Masyarakat::updateOrCreate(
                ['username' => $item['username']],
                [
                    'name' => $item['name'],
                    'username' => $item['username'],
                    'telp' => $item['telp'],
                    'status' => $item['status'],
                    'password' => bcrypt($item['password']),
                ]
            );
        }
        $datalevels = [
            ['level' => 'administrator'],
            ['level' => 'petugas'],
        ];
        foreach ($datalevels as $item) {
            \App\Models\Level::updateOrCreate(
                ['level' => $item['level']],
                []
            );
        }
        $dataPetugas =[
            [
                'nama_petugas' => 'admin',
                'username' => 'admin',
                'password' => '123456789',
                'id_level' => 1,
            ],
            [
                'nama_petugas' => 'Petugas1',
                'username' => 'petugas1',
                'password' => '123456789',
                'id_level' => 2,
            ],

        ];
        foreach ($dataPetugas as $item) {
            \App\Models\Petugas::updateOrCreate(
                ['username' => $item['username']],
                [
                    'nama_petugas' => $item['nama_petugas'],
                    'username' => $item['username'],
                    'password' => bcrypt($item['password']),
                    'id_level' => $item['id_level'],
                ]
            );
        }
    }
}
