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
}
