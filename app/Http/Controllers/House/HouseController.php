<?php
/**
 * Created by PhpStorm.
 * User: xuweiqi
 * Date: 2018/12/8
 * Time: 14:34
 */

namespace App\Http\Controllers\House;

use App\Http\Controllers\BaseController;

class HouseController extends BaseController
{
    public function index()
    {
        return view('house.index', ['data' => '']);
    }
}