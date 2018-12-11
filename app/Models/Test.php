<?php

namespace App\Models;

use App\Models\BaseModel;

class Test extends BaseModel
{
    protected $table = 'community';

    public function get()
    {
        $builder = $this;

        return $builder
            ->limit(5)
            ->get()->toArray();
    }
}
