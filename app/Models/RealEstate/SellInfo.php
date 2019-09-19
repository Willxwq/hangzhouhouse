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

        $ob = DB::connection($this->connectionArr[$params['city']])->table('sellinfo as s')
            ->select(DB::raw($select ." AS ups_or_downs"))
            ->addSelect("s.title","s.totalPrice AS salePrice", "s.listing_price AS totalPrice", "s.link", "s.dealdate",
                                "s.unitPrice", "c.his", "s.community", "s.square", "s.cycle")
            //->leftJoin('houseinfo as h', 's.houseID', '=', 'h.houseID')
            ->leftJoin('community', 'community.title', '=', 's.community')
            ->leftjoin(DB::raw("(SELECT houseID, group_concat( totalPrice ORDER BY date ASC SEPARATOR '->') AS his FROM hisprice GROUP BY houseID) AS c"),'c.houseID','=','s.houseID')
            ->where('s.dealdate', '>=', $startTime)
            ->where('s.dealdate', '<=', date('Y-m-d', time()))
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

    public function priceRiseAndDecline($params)
    {
        return DB::connection($this->connectionArr[$params['city']])
            ->table('sellinfo as s')
            ->select(DB::raw(
                "YEAR( dealdate ) AS deldate_year,
                    SUM( CASE WHEN MONTH ( dealdate ) = 1 THEN totalPrice ELSE 0 END ) price_1,
                    SUM( CASE WHEN MONTH ( dealdate ) = 1 THEN square ELSE 0 END ) square_1,
                    SUM( CASE WHEN MONTH ( dealdate ) = 2 THEN totalPrice ELSE 0 END ) price_2,
                    SUM( CASE WHEN MONTH ( dealdate ) = 2 THEN square ELSE 0 END ) square_2,
                    SUM( CASE WHEN MONTH ( dealdate ) = 3 THEN totalPrice ELSE 0 END ) price_3,
                    SUM( CASE WHEN MONTH ( dealdate ) = 3 THEN square ELSE 0 END ) square_3,
                    SUM( CASE WHEN MONTH ( dealdate ) = 4 THEN totalPrice ELSE 0 END ) price_4,
                    SUM( CASE WHEN MONTH ( dealdate ) = 4 THEN square ELSE 0 END ) square_4,
                    SUM( CASE WHEN MONTH ( dealdate ) = 5 THEN totalPrice ELSE 0 END ) price_5,
                    SUM( CASE WHEN MONTH ( dealdate ) = 5 THEN square ELSE 0 END ) square_5,
                    SUM( CASE WHEN MONTH ( dealdate ) = 6 THEN totalPrice ELSE 0 END ) price_6,
                    SUM( CASE WHEN MONTH ( dealdate ) = 6 THEN square ELSE 0 END ) square_6,
                    SUM( CASE WHEN MONTH ( dealdate ) = 7 THEN totalPrice ELSE 0 END ) price_7,
                    SUM( CASE WHEN MONTH ( dealdate ) = 7 THEN square ELSE 0 END ) square_7,
                    SUM( CASE WHEN MONTH ( dealdate ) = 8 THEN totalPrice ELSE 0 END ) price_8,
                    SUM( CASE WHEN MONTH ( dealdate ) = 8 THEN square ELSE 0 END ) square_8,
                    SUM( CASE WHEN MONTH ( dealdate ) = 9 THEN totalPrice ELSE 0 END ) price_9,
                    SUM( CASE WHEN MONTH ( dealdate ) = 9 THEN square ELSE 0 END ) square_9,
                    SUM( CASE WHEN MONTH ( dealdate ) = 10 THEN totalPrice ELSE 0 END ) price_10,
                    SUM( CASE WHEN MONTH ( dealdate ) = 10 THEN square ELSE 0 END ) square_10,
                    SUM( CASE WHEN MONTH ( dealdate ) = 11 THEN totalPrice ELSE 0 END ) price_11,
                    SUM( CASE WHEN MONTH ( dealdate ) = 11 THEN square ELSE 0 END ) square_11,
                    SUM( CASE WHEN MONTH ( dealdate ) = 12 THEN totalPrice ELSE 0 END ) price_12,
                    SUM( CASE WHEN MONTH ( dealdate ) = 12 THEN square ELSE 0 END ) square_12,
                    group_concat( CASE WHEN MONTH(dealdate) =1 THEN unitPrice ELSE 0 END ) median_1,
                    group_concat( CASE WHEN MONTH(dealdate) =2 THEN unitPrice ELSE 0 END ) median_2,
                    group_concat( CASE WHEN MONTH(dealdate) =3 THEN unitPrice ELSE 0 END ) median_3,
                    group_concat( CASE WHEN MONTH(dealdate) =4 THEN unitPrice ELSE 0 END ) median_4,
                    group_concat( CASE WHEN MONTH(dealdate) =5 THEN unitPrice ELSE 0 END ) median_5,
                    group_concat( CASE WHEN MONTH(dealdate) =6 THEN unitPrice ELSE 0 END ) median_6,
                    group_concat( CASE WHEN MONTH(dealdate) =7 THEN unitPrice ELSE 0 END ) median_7,
                    group_concat( CASE WHEN MONTH(dealdate) =8 THEN unitPrice ELSE 0 END ) median_8,
                    group_concat( CASE WHEN MONTH(dealdate) =9 THEN unitPrice ELSE 0 END ) median_9,
                    group_concat( CASE WHEN MONTH(dealdate) =10 THEN unitPrice ELSE 0 END ) median_10,
                    group_concat( CASE WHEN MONTH(dealdate) =11 THEN unitPrice ELSE 0 END ) median_11,
                    group_concat( CASE WHEN MONTH(dealdate) =12 THEN unitPrice ELSE 0 END ) median_12,
                    COUNT( dealdate )"
            ))
            ->groupBy('deldate_year')
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
