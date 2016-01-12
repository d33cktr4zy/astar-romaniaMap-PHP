<?php

use Illuminate\Database\Seeder;

class HeuristicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('heuristic')->truncate();
        DB::table('heuristic')->insert([
            [
                'idKota'    => '1',
                'hCost'     => '80'
            ],
            [
                'idKota'    => '2',
                'hCost'     => '80'
            ],
            [
                'idKota'    => '3',
                'hCost'     => '60'
            ],
            [
                'idKota'    => '4',
                'hCost'     => '85'
            ],
            [
                'idKota'    => '5',
                'hCost'     => '70'
            ],
            [
                'idKota'    => '6',
                'hCost'     => '74'
            ],
            [
                'idKota'    => '7',
                'hCost'     => '70'
            ],
            [
                'idKota'    => '8',
                'hCost'     => '25'
            ],
            [
                'idKota'    => '9',
                'hCost'     => '40'
            ],
            [
                'idKota'    => '10',
                'hCost'     => '35'
            ],
            [
                'idKota'    => '11',
                'hCost'     => '69'
            ],
            [
                'idKota'    => '12',
                'hCost'     => '100'
            ],
            [
                'idKota'    => '13',
                'hCost'     => '30'
            ],
            [
                'idKota'    => '14',
                'hCost'     => '70'
            ],
            [
                'idKota'    => '15',
                'hCost'     => '20'
            ],
            [
                'idKota'    => '16',
                'hCost'     => '30'
            ],
            [
                'idKota'    => '17',
                'hCost'     => '70'
            ],
            [
                'idKota'    => '18',
                'hCost'     => '45'
            ],
            [
                'idKota'    => '19',
                'hCost'     => '112'
            ],
            [
                'idKota'    => '20',
                'hCost'     => '120'
            ],
        ]);
    }
}
