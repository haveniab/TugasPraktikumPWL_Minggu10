<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaMataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $matakuliah = [
            [
                'mahasiswa_id' => '56789',
                'matakuliah_id' => '1',
                'nilai' => 'B',
            ],
            [

                'mahasiswa_id' => '56789',
                'matakuliah_id' => '2',
                'nilai' => 'A',
            ],
            [

                'mahasiswa_id' => '56789',
                'matakuliah_id' => '3',
                'nilai' => 'B+',
            ],
            [
                'mahasiswa_id' => '56789',
                'matakuliah_id' => '4',
                'nilai' => 'B',
            ],

            [
                'mahasiswa_id' => '1234567811',
                'matakuliah_id' => '1',
                'nilai' => 'A',
            ],
            [

                'mahasiswa_id' => '1234567811',
                'matakuliah_id' => '2',
                'nilai' => 'A',
            ],
            [

                'mahasiswa_id' => '1234567811',
                'matakuliah_id' => '3',
                'nilai' => 'A',
            ],
            [
                'mahasiswa_id' => '1234567811',
                'matakuliah_id' => '4',
                'nilai' => 'A',
            ],

            [
                'mahasiswa_id' => '1181688222',
                'matakuliah_id' => '1',
                'nilai' => 'B',
            ],
            [
                'mahasiswa_id' => '1181688222',
                'matakuliah_id' => '2',
                'nilai' => 'B',
            ],
            [
                'mahasiswa_id' => '1181688222',
                'matakuliah_id' => '3',
                'nilai' => 'A',
            ],
            [
                'mahasiswa_id' => '1181688222',
                'matakuliah_id' => '4',
                'nilai' => 'B',
            ],
        ];

        DB::table('mahasiswa_matakuliah')->insert($matakuliah);
    }
}
