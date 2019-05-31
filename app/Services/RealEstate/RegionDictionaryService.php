<?php

namespace App\Services\RealEstate;

use App\Models\RealEstate\HouseInfo;
use App\Models\RealEstate\RegionDictionary;
use App\Services\BaseServices;

class RegionDictionaryService extends BaseServices
{
    public static function getRegionList($type, $districtId, $city)
    {
        return (new RegionDictionary())->getRegionList($type, $districtId, $city);
    }

    public static function getHouseTypeByCommunity($communityName)
    {
        return (new HouseInfo())->getHouseInfoByCommunity($communityName);
    }
}
