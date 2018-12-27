<?php

namespace App\Services\RealEstate;

use App\Models\RealEstate\Community;
use App\Models\RealEstate\RegionDictionary;

class RegionDictionaryService
{
    public static function getRegionList($type, $districtId)
    {
        $regionDictionary = new RegionDictionary();

        return $regionDictionary->getRegionList($type, $districtId);
    }

    public static function getCommunityDetailByBizcircle($params)
    {
        $community = new Community();

        return $community->getReggetCommunityDetailByBizcircleionList($params);
    }

    public static function getCommunListChart()
    {

    }
}
