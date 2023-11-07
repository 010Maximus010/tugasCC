<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nim_nip' => '45872314',
                'nama' => 'Operator IF',
                'email' => 'operator@if.com',
                'password' => Hash::make('123'),
                'role' => 'operator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim_nip' => '24060121130080',
                'nama' => 'Mahasiswa 2021',
                'email' => 'mahasiswa2021@if.com',
                'password' => Hash::make('123'),
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim_nip' => 'D.1.289103252009130094',
                'nama' => 'Dosen IF',
                'email' => 'dosen@if.com',
                'password' => Hash::make('123'),
                'role' => 'dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim_nip' => '38076',
                'nama' => 'Departemen IF',
                'email' => 'departemen@if.com',
                'password' => Hash::make('123'),
                'role' => 'departemen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim_nip' => '24060121130085',
                'nama' => 'Mochammad Arya Jadmika',
                'email' => 'arya@if.com',
                'password' => Hash::make('123'),
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim_nip' => '24060121120029',
                'nama' => 'Lulus Dwiyan Mita',
                'email' => 'lulus@if.com',
                'password' => Hash::make('123'),
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim_nip' => '24060121120033',
                'nama' => 'Nafis Mufadhal',
                'email' => 'nafis@if.com',
                'password' => Hash::make('123'),
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim_nip' => '24060121140141',
                'nama' => 'Muhammad Afiat Yulianto',
                'email' => 'afiat@if.com',
                'password' => Hash::make('123'),
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('mahasiswas')->insert([
            [
                'nim' => '24060121130080',
                'nama' => 'Mahasiswa 2021',
                'email' => 'mahasiswa2021@if.com',
                'jalur_masuk' => 'SNMPTN',
                'angkatan' => '2021',
                'status' => 'Aktif',
            ],
            [
                'nim' => '24060121130085',
                'nama' => 'Mochammad Arya Jadmika',
                'email' => 'arya@if.com',
                'jalur_masuk' => 'SBMPTN',
                'angkatan' => '2021',
                'status' => 'Aktif',
            ],
            [
                'nim' => '24060121120029',
                'nama' => 'Lulus Dwiyan Mita',
                'email' => 'lulus@if.com',
                'jalur_masuk' => 'SNMPTN',
                'angkatan' => '2021',
                'status' => 'Aktif',
            ],
            [
                'nim' => '24060121120033',
                'nama' => 'Nafis Mufadhal',
                'email' => 'nafis@if.com',
                'jalur_masuk' => 'SNMPTN',
                'angkatan' => '2021',
                'status' => 'Aktif',
            ],
            [
                'nim' => '24060121140141',
                'nama' => 'Muhammad Afiat Yulianto',
                'email' => 'afiat@if.com',
                'jalur_masuk' => 'Ujian Mandiri',
                'angkatan' => '2021',
                'status' => 'Aktif',
            ]
        ]);

        DB::table('dosens')->insert(
            [
                'nip' => 'D.1.289103252009130094',
                'nama' => 'Dosen IF',
                'email' => 'dosen@if.com',
                'status' => 'Aktif',
            ]
        );
    }
}
