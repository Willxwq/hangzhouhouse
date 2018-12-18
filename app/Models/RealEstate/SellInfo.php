<?php

namespace App\Models\RealEstate;

use App\Models\BaseModel;

class SellInfo extends BaseModel
{
    protected $table = 'sellinfo';

    public function get()
    {
        $builder = $this;

        return $builder
            ->limit(5)
            ->get()->toArray();
    }
}
