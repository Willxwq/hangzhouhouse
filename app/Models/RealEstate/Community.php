<?php

namespace App\Models\RealEstate;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class Community extends BaseModel
{
    protected $table = 'community';

    public function get()
    {
        $builder = $this;

        return $builder
            ->limit(5)
            ->get()->toArray();
    }

    public function numOfCellsInEachRegion()
    {
        return $this->select(DB::raw('count(*) AS y'), 'district AS x')
            ->groupBy('district')
            ->get()
            ->toArray();
    }

    public function deepTest()
    {
        //return $this->select("district", "bizcircle", "year", "housetype", "house_num", "price")
        return $this->select("year", "house_num", "price")
            ->limit(100)
            ->get()
            ->toArray();
    }

    public function averagePriceRankingOfEachRegion()
    {
        return $this->select(DB::raw('ROUND(AVG(price), 2) AS y'), 'district AS x')
            ->groupBy('district')
            ->get()
            ->toArray();
    }

    public function getReggetCommunityDetailByBizcircleionList($params)
    {
        $ob = $this->where('bizcircle', '=', $params['bizcircle']);
        $count = $ob->count();

        if ($count) {
            $data['total'] = $count;
            $data['curPage'] = $params['start'];
            $data['pageSize'] = $params['length'];
            $data['totalPage'] = ceil($count / $params['length']);
        }
        $data['rows'] = $ob
            ->offset($params['start'])
            ->limit($params['length'])
            ->get()
            ->toArray();
        return $data;
    }

    public function getCommunityDetail($communityName)
    {
        return $this->where('title', '=', $communityName)
            ->first()
            ->toArray();
    }

    public function getAllCommunity()
    {
        return $this
            ->select("title", "id")
            ->whereNull("lng")
            ->get()
            ->toArray();
    }

    public function updateBatch($multipleData = [])
    {
        try {
            if (empty($multipleData)) {
                throw new \Exception("数据不能为空");
            }
            $tableName = DB::getTablePrefix() . $this->getTable(); // 表名
            $firstRow  = current($multipleData);

            $updateColumn = array_keys($firstRow);
            // 默认以id为条件更新，如果没有ID则以第一个字段为条件
            $referenceColumn = isset($firstRow['id']) ? 'id' : current($updateColumn);
            unset($updateColumn[0]);
            // 拼接sql语句
            $updateSql = "UPDATE " . $tableName . " SET ";
            $sets      = [];
            $bindings  = [];
            foreach ($updateColumn as $uColumn) {
                $setSql = "`" . $uColumn . "` = CASE ";
                foreach ($multipleData as $data) {
                    $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN ? ";
                    $bindings[] = $data[$referenceColumn];
                    $bindings[] = $data[$uColumn];
                }
                $setSql .= "ELSE `" . $uColumn . "` END ";
                $sets[] = $setSql;
            }
            $updateSql .= implode(', ', $sets);
            $whereIn   = collect($multipleData)->pluck($referenceColumn)->values()->all();
            $bindings  = array_merge($bindings, $whereIn);
            $whereIn   = rtrim(str_repeat('?,', count($whereIn)), ',');
            $updateSql = rtrim($updateSql, ", ") . " WHERE `" . $referenceColumn . "` IN (" . $whereIn . ")";
            // 传入预处理sql语句和对应绑定数据
            return DB::update($updateSql, $bindings);
        } catch (\Exception $e) {
            return false;
        }
    }

}
