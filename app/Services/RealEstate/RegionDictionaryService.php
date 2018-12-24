<?php

namespace App\Services\RealEstate;

use App\Models\RealEstate\Community;
use App\Models\RealEstate\RegionDictionary;

class RegionDictionaryService
{
    public function getRegionList($type, $districtId)
    {
        $regionDictionary = new RegionDictionary();

        return $regionDictionary->getRegionList($type, $districtId);
    }

    public function getCommunityDetailByBizcircle($bizcircle)
    {
        $community = new Community();

        return $community->getReggetCommunityDetailByBizcircleionList($bizcircle);
    }
   
}
