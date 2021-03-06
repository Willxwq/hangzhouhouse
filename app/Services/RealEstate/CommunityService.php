<?php

namespace App\Services\RealEstate;

use App\Models\RealEstate\Community;
use App\Services\BaseServices;

class CommunityService  extends BaseServices
{
    public static function getCommunityDetailByBizcircle($params)
    {
        return (new Community)->getReggetCommunityDetailByBizcircleionList($params);
    }

    public static function getCommunityDetail($communityName)
    {
        return (new Community)->getCommunityDetail($communityName);
    }

    public static function getAllCommunity()
    {
        return (new Community())->getAllCommunity();
    }

    public static function saveLngAndLat($param)
    {
        return (new Community())->updateBatch($param);
    }
}
