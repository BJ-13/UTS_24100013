<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        
        Mahasiswa::truncate();

        $data = [
            ['NIM' => '23100013', 'name' => 'RYAN FEBRIANTO'],
            ['NIM' => '23110001', 'name' => 'KELIO XENELLY'],
            ['NIM' => '23110002', 'name' => 'ALVIN VALENTINO'],
            ['NIM' => '23110006', 'name' => 'DHAVID BHERTUS'],
            ['NIM' => '23110007', 'name' => 'ALDO RIVALDI'],
            ['NIM' => '23110009', 'name' => 'FELIX FILBERT'],
            ['NIM' => '23110010', 'name' => 'VITA'],
            ['NIM' => '23110011', 'name' => 'CELLO FIBRYAN GIRL'],
            ['NIM' => '23110015', 'name' => 'WENDI'],
            ['NIM' => '23110017', 'name' => 'BRYAN HENRILSEN'],
            ['NIM' => '23110018', 'name' => 'FERNANDO JOCEVINE'],
            ['NIM' => '23110021', 'name' => 'STEVEN EDMUND PRATAMA'],
            ['NIM' => '23110022', 'name' => 'JACKY FERNANDO'],
            ['NIM' => '23110023', 'name' => 'STENLY KURNIAWAN'],
            ['NIM' => '23110027', 'name' => 'RONNEY PANGNATHAN'],
        ];

        foreach ($data as $item) {
            Mahasiswa::create([
                'id' => (string) Str::uuid(),
                'NIM' => $item['NIM'],
                'name' => $item['name'],
                'jurusan' => 'Sistem dan Teknologi Informasi',
            ]);
        }
    }
}