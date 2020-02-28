<?php

namespace App\Models\RealEstate;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class SellInfo extends BaseModel
{
    protected $connectionArr = ['mysql', 'mysql_sh', 'mysql_gz', 'mysql_cq', 'mysql_cd', 'mysql_sz', 'mysql_hf'];
    protected $table = 'sellinfo';

    public function get()
    {
        $builder = $this;

        return $builder
            ->limit(5)
            ->get()->toArray();
    }

    public function getSellInfoByCommunity($communityName)
    {
        /* 打印SQL
         * DB::connection()->enableQueryLog();
        $result = DB::table('sellinfo as s')->get();
        $log = DB::getQueryLog();
        self::elog($log);*/
        //return $this->select(DB::raw("DATE_FORMAT(dealdate,'%Y-%m') as time, ROUND(AVG(unitPrice)) AS unitPrice"))
        return $this->select(DB::raw("DATE_FORMAT(dealdate,'%Y-%m') as time, count(*) AS count, ROUND(AVG(unitPrice)) AS unitPrice"))
            ->where('community', '=', $communityName)
            ->groupBy('time')
            ->get()
            ->toArray();
    }

    public function getSellUpsAndDowns($params)
    {
        $startTime = date('Y-m-d',strtotime('-'. $params['time'] .' month'));
        if ($params['showType'] == 1) {
            if ($params['type'] == 1) {
                $num = "s.totalPrice / s.listing_price";
            } else {
                $num = "s.listing_price / s.totalPrice";
            }
            $select = "TRUNCATE((1 - ". $num .") * 100, 2)";
            $num = "(1 - ". $num .")";
        } else {
            if ($params['type'] == 1) {
                $num = "s.listing_price - s.totalPrice";
            } else {
                $num = "s.totalPrice - s.listing_price";
            }
            $select = $num;
        }

        $time = date('Y-m-d', time());

        DB::connection()->enableQueryLog();
        $ob = DB::table('sellinfo as s')
            ->select(DB::raw($select ." AS ups_or_downs"))
            ->addSelect("s.title","s.totalPrice AS salePrice", "s.listing_price AS totalPrice", "s.link", "s.dealdate",
                                "s.unitPrice", "c.his", "s.community", "s.square", "s.cycle")
            //->leftJoin('houseinfo as h', 's.houseID', '=', 'h.houseID')
            ->leftJoin('community', 'community.title', '=', 's.community')
            //->leftjoin(DB::raw("(SELECT houseID, group_concat( totalPrice ORDER BY date ASC SEPARATOR '->') AS his FROM hisprice GROUP BY houseID) AS c"),'c.houseID','=','s.houseID')
            ->leftjoin(DB::raw("(
               SELECT
                    h.houseID,
                    group_concat( h.totalPrice ORDER BY h.date ASC SEPARATOR '->' ) AS his 
               FROM
                    hisprice AS h
                    LEFT JOIN sellinfo AS s ON s.houseID = h.houseID 
               WHERE
                    s.dealdate >= '". $startTime ."'
                    AND `s`.`dealdate` <= '" .$time. "' AND ( 1 - s.totalPrice / s.listing_price ) > 0 
                    AND ".$num." > 0
                    AND (s.totalPrice - s.listing_price) IS NOT NULL
               GROUP BY
                    houseID
               ) AS c
               "),'c.houseID','=','s.houseID'
            )
            ->where('s.dealdate', '>=', $startTime)
            ->where('s.dealdate', '<=', $time)
            ->whereRaw($num ." > 0")
            ->whereRaw('(s.totalPrice - s.listing_price) IS NOT NULL');

        if (!empty($params['bizcircle'])) {
            $ob->where('community.bizcircle', '=', $params['bizcircle']);
        }

        if (!empty($params['communityName'])) {
            $ob->where('s.community', 'like', '%'. $params['communityName'] .'%');
        }

        if ($params['maxSquare'] != null && $params['minSquare'] != null) {
            $ob->whereRaw("substring_index(s.square, '平', 1) BETWEEN ". $params['minSquare'] ." AND ". $params['maxSquare']);
        }

        if ($params['maxTotalPrice'] != null && $params['minTotalPrice'] != null) {
            $ob->whereBetween('totalPrice', [$params['minTotalPrice'], $params['maxTotalPrice']]);
        }

        if ($params['maxUnitPrice'] != null && $params['minUnitPrice'] != null) {
            $ob->whereBetween('unitPrice', [$params['minUnitPrice'] * 10000, $params['maxUnitPrice'] * 10000]);
        }

        $ob->orderBy('ups_or_downs', 'desc');
        $count = $ob->count();

        if ($count) {
            if (isset($params['isExport'])) {
                $params['length'] = $count;
            }

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

        //$data['total'] = $count;
        //$data['curPage'] = 1;
        //$data['pageSize'] = 1;
        //$data['totalPage'] = 1;

        return $data;
    }

    public function getSellList($params)
    {
        $startTime = date('Y-m-d',strtotime('-'. $params['time'] .' month'));
        if ($params['showType'] == 1) {
            if ($params['type'] == 1) {
                $select = "TRUNCATE((1 - `houseinfo`.`totalPrice` / substring_index( group_concat( hp.totalPrice ORDER BY hp.date ), ',', 1 )) * 100, 2) AS agio";
            } else {
                $select = "TRUNCATE((1 - substring_index( group_concat( hp.totalPrice ORDER BY hp.date ), ',', 1 ) / `houseinfo`.`totalPrice` ) * 100, 2) AS agio";
            }
        } else {
            if ($params['type'] == 1) {
                $select = " substring_index( group_concat( hp.totalPrice ORDER BY hp.date ), ',', 1 ) - `houseinfo`.`totalPrice` AS agio ";
            } else {
                $select = " `houseinfo`.`totalPrice` - substring_index( group_concat( hp.totalPrice ORDER BY hp.date ), ',', 1 ) AS agio ";
            }
        }

        DB::connection()->enableQueryLog();
        $ob = DB::table('hisprice as hp')
            ->select(DB::raw($select . " , group_concat( hp.totalPrice ORDER BY hp.date ASC SEPARATOR '>' ) AS priceAdjust "))
            ->addSelect('houseinfo.houseID', 'houseinfo.totalPrice', 'houseinfo.link',
                'houseinfo.community', 'houseinfo.square', 'houseinfo.title',
                'houseinfo.validdate', 'houseinfo.unitPrice')
            ->leftJoin('houseinfo', 'houseinfo.houseID', '=', 'hp.houseID')
            ->leftJoin('community', 'community.title', '=', 'houseinfo.community')
            ->leftJoin('sellinfo', 'sellinfo.houseID', '=', 'hp.houseID')
            ->whereNull('sellinfo.totalPrice')
            ->where('houseinfo.validdate', '>=', $startTime)
            ->where('houseinfo.shelf', "=", "1");

        if (!empty($params['bizcircle'])) {
            $ob->where('community.bizcircle', '=', $params['bizcircle']);
        }

        if (!empty($params['communityName'])) {
            $ob->where('houseinfo.community', 'like', '%'. $params['communityName'] .'%');
        } else {
            $ob->where('houseinfo.community', '=', '寰宇天下');
        }

        if ($params['maxSquare'] != null && $params['minSquare'] != null) {
            $ob->whereRaw("substring_index(houseinfo.square, '平', 1) BETWEEN ". $params['minSquare'] ." AND ". $params['maxSquare']);
        }

        if ($params['maxTotalPrice'] != null && $params['minTotalPrice'] != null) {
            $ob->whereBetween('houseinfo.totalPrice', [$params['minTotalPrice'], $params['maxTotalPrice']]);
        }

        if ($params['maxUnitPrice'] != null && $params['minUnitPrice'] != null) {
            $ob->whereBetween('houseinfo.unitPrice', [$params['minUnitPrice'] * 10000, $params['maxUnitPrice'] * 10000]);
        }

        $count = $ob->count();

        if ($count) {
            if (isset($params['isExport'])) {
                $params['length'] = $count;
            }

            $data['total'] = $count;
            $data['curPage'] = $params['start'];
            $data['pageSize'] = $params['length'];
            $data['totalPage'] = ceil($count / $params['length']);
        }
        $ob->groupBy('hp.houseID');
        $ob->orderBy('agio', 'DESC');

        $data['rows'] = $ob
            ->offset($params['start'])
            ->limit($params['length'])
            ->get()
            ->toArray();

        return $data;
    }

    public function priceRiseAndDecline($params)
    {
        return DB::connection($this->connectionArr[$params['city']])
            ->table('sellinfo')
            ->select(DB::raw(
                "SUM( totalPrice ) AS totalPrice,
                    SUM( square ) AS square,
                    group_concat( unitPrice ) AS unitPrice,
                    count( * ) AS sellCount,
                    YEAR ( dealdate ) AS year,
                    MONTH ( dealdate ) AS month"
            ))
            ->groupBy(DB::raw('YEAR ( dealdate ), MONTH ( dealdate )'))
            ->get()
            ->toArray();
    }

    public function getMonthSell($timeArr)
    {
        $data = $this
            ->addSelect("c.lng", "c.lat", "c.id", "sellinfo.unitPrice")
            ->leftJoin('community AS c', 'c.title', '=', 'sellinfo.community')
            //->whereRaw("DATE_FORMAT( sellinfo.`dealdate`, '%Y%m' ) = DATE_FORMAT( CURDATE() , '%Y%m' )")
            ->whereBetween("dealdate", $timeArr)
            ->get()
            ->toArray();

        return $data;
    }

}
