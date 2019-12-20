<?php

namespace App\Services\RealEstate;

use App\Services\BaseServices;

class TestDataService  extends BaseServices
{
    public static function getTestData()
    {
        $result = [];
        $testArr = json_decode(file_get_contents("/Users/xuweiqi/var/test.json"), true);
        foreach ($testArr['skuCodeArr'] as $itemK => $itemV) {
            $result[] = explode(',', $itemV['skuCode']);
            if ($itemK >= 1000) break;
        }

        return $result;
    }
}
