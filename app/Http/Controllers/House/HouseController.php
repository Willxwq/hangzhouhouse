<?php
/**
 * Created by PhpStorm.
 * User: xuweiqi
 * Date: 2018/12/8
 * Time: 14:34
 */

namespace App\Http\Controllers\House;

use App\Http\Controllers\Controller;
use App\Models\Test;

class HouseController extends Controller
{
    public function index()
    {
        $test = new Test();

        $data = $test->get();

        return view('house.index', ['data' => '$data']);
    }
}