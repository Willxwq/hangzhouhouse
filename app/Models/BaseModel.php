<?php

namespace App\Models;

use App\Lib\ElogService;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Http\Request;

class BaseModel extends EloquentModel
{
    use ElogService;

    public function toArray()
    {
        return array_map(function($data) {
            return strval($data);
        }, parent::toArray());
    }
}
