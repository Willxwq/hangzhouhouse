<?php

namespace App\Models\RealEstate;

use App\Models\BaseModel;

class RentInfo extends BaseModel
{
    protected $table = 'rentinfo';

    public function get()
    {
        $builder = $this;

        return $builder
            ->limit(5)
            ->get()->toArray();
    }
}
