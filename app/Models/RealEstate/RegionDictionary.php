<?php

namespace App\Models\RealEstate;

use App\Models\BaseModel;

class RegionDictionary extends BaseModel
{
    protected $table = 'region_dictionary';

    public function get()
    {
        return $this
            ->limit(5)
            ->get()->toArray();
    }

    public function getRegionList($type = 1, $districtId)
    {
        $result = $this->where('type', '=', $type);
        if (!empty($districtId)) {
            $result->where('districtId', '=', $districtId);
        }
        return $result->get()->toArray();
    }
}
