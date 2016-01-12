<?php

use Illuminate\Database\Seeder;

class RealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('real')->truncate();
        DB::table('real')->insert([
            [
                'idKotaAsal'    => '1',
                'idKotaTujuan'  => '2',
                'gCost'         => '75'
            ],
            [
                'idKotaAsal'    => '1',
                'idKotaTujuan'  => '5',
                'gCost'         => '118'
            ],
            [
                'idKotaAsal'    => '1',
                'idKotaTujuan'  => '4',
                'gCost'         => '140'
            ],
            [
                'idKotaAsal'    => '2',
                'idKotaTujuan'  => '3',
                'gCost'         => '71'
            ],
            [
                'idKotaAsal'    => '3',
                'idKotaTujuan'  => '4',
                'gCost'         => '151'
            ],
            [
                'idKotaAsal'    => '5',
                'idKotaTujuan'  => '6',
                'gCost'         => '111'
            ],
            [
                'idKotaAsal'    => '4',
                'idKotaTujuan'  => '9',
                'gCost'         => '80'
            ],
            [
                'idKotaAsal'    => '4',
                'idKotaTujuan'  => '8',
                'gCost'         => '99'
            ],
            [
                'idKotaAsal'    => '6',
                'idKotaTujuan'  => '7',
                'gCost'         => '70'
            ],
            [
                'idKotaAsal'    => '7',
                'idKotaTujuan'  => '10',
                'gCost'         => '75'
            ],
            [
                'idKotaAsal'    => '10',
                'idKotaTujuan'  => '11',
                'gCost'         => '120'
            ],
            [
                'idKotaAsal'    => '9',
                'idKotaTujuan'  => '11',
                'gCost'         => '146'
            ],
            [
                'idKotaAsal'    => '9',
                'idKotaTujuan'  => '12',
                'gCost'         => '97'
            ],
            [
                'idKotaAsal'    => '11',
                'idKotaTujuan'  => '12',
                'gCost'         => '138'
            ],
            [
                'idKotaAsal'    => '8',
                'idKotaTujuan'  => '13',
                'gCost'         => '211'
            ],
            [
                'idKotaAsal'    => '12',
                'idKotaTujuan'  => '13',
                'gCost'         => '101'
            ],
            [
                'idKotaAsal'    => '13',
                'idKotaTujuan'  => '14',
                'gCost'         => '90'
            ],
            [
                'idKotaAsal'    => '13',
                'idKotaTujuan'  => '15',
                'gCost'         => '85'
            ],
            [
                'idKotaAsal'    => '15',
                'idKotaTujuan'  => '18',
                'gCost'         => '142'
            ],
            [
                'idKotaAsal'    => '18',
                'idKotaTujuan'  => '19',
                'gCost'         => '92'
            ],
            [
                'idKotaAsal'    => '19',
                'idKotaTujuan'  => '20',
                'gCost'         => '87'
            ],
            [
                'idKotaAsal'    => '15',
                'idKotaTujuan'  => '16',
                'gCost'         => '98'
            ],
            [
                'idKotaAsal'    => '16',
                'idKotaTujuan'  => '17',
                'gCost'         => '86'
            ],
        ]);
    }
}
