<?php

namespace App\Http\Controllers\RealEstate;

use App\Services\RealEstate\RegionDictionaryService;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Yajra\DataTables\DataTables;

class CommunityController extends BaseController
{
    public function index(Request $request, RegionDictionaryService $regionDictionaryService)
    {
        $params = $request->post();
        $bizcircle = empty($params['bizcircle'])? '': $params['bizcircle'];
        $data = self::getCommunityDetailByBizcircle($bizcircle, $regionDictionaryService);

        return view('realestate.community', ['data' => $data]);
    }

    public function getRegionList(RegionDictionaryService $regionDictionaryService, $type, $districtId)
    {
        $list = $regionDictionaryService->getRegionList($type, $districtId);

        return $this->format(200, $list);
    }

    public static function getCommunityDetailByBizcircle($bizcircle, RegionDictionaryService $regionDictionaryService)
    {
        $list = $regionDictionaryService->getCommunityDetailByBizcircle($bizcircle);

        //self::elog($list);
        self::elog(Datatables::of($list)->make(true));
        //return Datatables::of($list)->make(true);
    }
}
