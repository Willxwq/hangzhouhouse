<?php

namespace App\Models\RealEstate;

use App\Models\BaseModel;

class HouseInfo extends BaseModel
{
    protected $table = 'houseinfo';

    public function get()
    {
        $builder = $this;

        return $builder
            ->limit(5)
            ->get()->toArray();
    }

    public function getHouseInfoByCommunity($communityName)
    {
        return $this->where('community', '=', $communityName)
            ->get()
            ->toArray();
    }
}
