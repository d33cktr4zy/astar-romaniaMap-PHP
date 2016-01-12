<?php

use Illuminate\Database\Seeder;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kota')->truncate();
        DB::table('kota')->insert([
            [
                'idKota'    => '1',
                'namaKota'  => 'Arad'
            ],
            [
                'idKota'    => '2',
                'namaKota'  => 'Zerind'
            ],
            [
                'idKota'    => '3',
                'namaKota'  => 'Oradea'
            ],
            [
                'idKota'    => '4',
                'namaKota'  => 'Sibiu'
            ],
            [
                'idKota'    => '5',
                'namaKota'  => 'Timisoara'
            ],
            [
                'idKota'    => '6',
                'namaKota'  => 'Lugoj'
            ],
            [
                'idKota'    => '7',
                'namaKota'  => 'Mehadia'
            ],
            [
                'idKota'    => '8',
                'namaKota'  => 'Fagaras'
            ],
            [
                'idKota'    => '9',
                'namaKota'  => 'Rimnicu Vilcea'
            ],
            [
                'idKota'    => '10',
                'namaKota'  => 'Dobreta'
            ],
            [
                'idKota'    => '11',
                'namaKota'  => 'Craiova'
            ],
            [
                'idKota'    => '12',
                'namaKota'  => 'Pitesti'
            ],
            [
                'idKota'    => '13',
                'namaKota'  => 'Bucharest'
            ],
            [
                'idKota'    => '14',
                'namaKota'  => 'Giurgiu'
            ],
            [
                'idKota'    => '15',
                'namaKota'  => 'Urziceni'
            ],
            [
                'idKota'    => '16',
                'namaKota'  => 'Hirsova'
            ],
            [
                'idKota'    => '17',
                'namaKota'  => 'Eforie'
            ],
            [
                'idKota'    => '18',
                'namaKota'  => 'Vasvui'
            ],
            [
                'idKota'    => '19',
                'namaKota'  => 'Iasi'
            ],
            [
                'idKota'    => '20',
                'namaKota'  => 'Neamt'
            ],

        ]);
    }
}
