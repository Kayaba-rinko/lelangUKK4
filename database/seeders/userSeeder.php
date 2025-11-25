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
                'name' => 'John Doe 1 ',
                'username' => '1111111111111111',
                'telp' => '081256881234',
                'alamat' => 'Jl. Dummy No.34',
                'status' => 'aktif',
                'password' => '123456789',
            ],
            [
                'name' => 'John Doe 2 ',
                'username' => '2222222222222222',
                'telp' => '081256881235',
                'alamat' => 'Jl. Dummy No.65',
                'status' => 'aktif',
                'password' => '123456789',
            ],
            [
                'name' => 'John Doe 3 ',
                'username' => '3333333333333333',
                'telp' => '081256881236',
                'alamat' => 'Jl. Dummy No.78',
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
                    'alamat' =>$item['alamat'],
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
                'nama_petugas' => 'Hoya',
                'username' => 'admin',
                'password' => '123456789',
                'id_level' => 1,
            ],
            [
                'nama_petugas' => 'Kama',
                'username' => 'ptg01',
                'password' => '123456789',
                'id_level' => 2,
            ],
            [
                'nama_petugas' => 'Itma',
                'username' => 'ptg02',
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
