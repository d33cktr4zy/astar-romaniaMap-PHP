<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/12/2016
 * Time: 03:38 AM
 */

namespace app\astar;
use Illuminate\Support\Debug\Dumper;

if (! function_exists('ddd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function ddd()
    {
        array_map(function ($x) {
            (new Dumper)->dump($x);
        }, func_get_args());

    }
}