<?php

namespace App;

use App\Facilitie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Boat extends Model
{
    protected $table = 'boat_tbl_boat';

    public function getBoatsByConditions($numberGuests, $occasion, $boatCat, $country, $priceOrder = 'asc')
    {
        $query = $this->query();

        if (!empty($numberGuests)) {
            $query->where('pax', '>', $numberGuests);
        }

        if (!empty($boatCat)) {
            $query->where('boat_type_tma', $boatCat);
        }

        if (!empty($country)) {
            $query->where('country', $country);
        }

        if ($priceOrder === 'asc') {
            $query->orderBy('price', 'asc');
        } else {
            $query->orderBy('price', 'desc');
        }

        $query->where('status', 'y');

        return $query->get();
    }

    /**
     * Get all boat base on status
     *
     * @param string $status
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getAllBoatsByStatus($status)
    {
        $query = DB::table('boat_time_price')
            ->select(
                'boat_tbl_boat.boat_id',
                'boat_name',
                'country',
                'pax',
                'main_photo',
                'photo1',
                'photo2',
                'photo3',
                'photo4',
                'photo5',
                'boat_tbl_boat.year_create',
                'boat_details',
                'boat_tbl_boat.beam',
                'head',
                'boat_tbl_boat.aircon',
                'boat_tbl_boat.gps',
                'boat_tbl_boat.vhf',
                'boat_tbl_boat.length',
                'fishfinder',
                'boat_tbl_category.category_name',
                'is_promoted',
                'boat_time_price.currency',
                DB::raw('(SELECT MIN(NULLIF(price,0)) FROM boat_time_price WHERE boat_time_price.boat_id = boat_tbl_boat.boat_id AND boat_time_price.price > 0) as `boat_price`  ')
            )
            ->join('boat_tbl_boat', 'boat_tbl_boat.boat_id', '=', 'boat_time_price.boat_id')
            ->join('boat_tbl_category', 'boat_tbl_category.category_id', '=', 'boat_tbl_boat.boat_type')
            ->where('boat_tbl_boat.status', $status)
            ->orderBy('boat_tbl_boat.add_date', 'DESC');

        return $query->groupBy('boat_id')->get();
    }

    /**
     * Get all boat base on marinas id
     *
     * @param array $marinasId
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getAllBoatTypeSameMarinas($boatTypeId, $marinasId, $priceOrder = 'asc')
    {
        return $this->readDb(function ($manager, $conn) use ($boatTypeId, $marinasId, $priceOrder) {
            $query = <<<EOF
SELECT bo.*, btp.currency, btp.boatPrice, boat_tbl_category_tma.category_name
FROM boat_tbl_boat bo
LEFT JOIN ( 
    SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price,0)) AS boatPrice 
    FROM boat_time_price btp
    INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id  and  btp.date_for >= NOW()
    GROUP BY btp.boat_id, btp.currency
) AS btp ON btp.boatId = bo.boat_id
INNER JOIN boat_tbl_category_tma ON boat_tbl_category_tma.category_id = bo.boat_type_tma
WHERE bo.boat_type_tma = ? AND bo.marina IN (?) AND bo.status = 'y'
EOF;
            if ($priceOrder === 'asc') {
                $query .= " ORDER BY btp.boatPrice ASC";
            } else {
                $query .= " ORDER BY btp.boatPrice DESC";
            }
            $stm = $conn->executeQuery($query, [$boatTypeId, $marinasId], array(\PDO::PARAM_INT, \Doctrine\DBAL\Connection::PARAM_INT_ARRAY));
            return $stm->fetchAll();
        });
    }

    public function getAllBoatsOfType($boatTypeId, $country = '', $priceOrder = 'asc')
    {
        $query = Boat::where('boat_type_tma', $boatTypeId)
            ->where('status', 'y');

        if (!empty($country)) {
            $query->where('country', $country);
        }

        if ($priceOrder === 'nasc') {
            $query->orderBy('boat_type_tma', 'asc');
        } else {
            if ($priceOrder === 'asc') {
                $query->orderBy('boat_name', 'asc');
            } else {
                $query->orderBy('boat_name', 'desc');
            }
        }

        // $query->toArray();
        return $query->get()->toArray();
    }

    public function getAllBoatsByConditions($numberGuests, $occasion, $boatCat, $country, $priceOrder = 'asc')
    {
        $now = now();
        $query = Boat::select('boat_tbl_boat.*', 'btp.currency', 'btp.boatPrice', 'boat_tbl_category_tma.category_name')->leftJoin(DB::raw('(SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price, 0)) AS boatPrice FROM boat_time_price btp INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id AND btp.date_for >= NOW() GROUP BY btp.boat_id, btp.currency) AS btp'), 'btp.boatId', '=', 'boat_tbl_boat.boat_id')->join('boat_tbl_category_tma', 'boat_tbl_category_tma.category_id', '=', 'boat_tbl_boat.boat_type_tma')->where('boat_tbl_boat.status', 'y');

        return $query->get();
    }

    public function getAllBoatHomeSameMarinas($numberGuests, $occasion, $boatCat, $marinasId, $priceOrder = 'asc')
    {
        $query = Boat::select(
            'boat_tbl_boat.*',
            'btp.currency',
            'btp.boatPrice',
            'boat_tbl_category_tma.category_name'
        )->leftJoin(DB::raw('(SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price,0)) AS boatPrice FROM boat_time_price btp INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id AND btp.date_for >= NOW() GROUP BY btp.boat_id, btp.currency) AS btp'), 'btp.boatId', '=', 'boat_tbl_boat.boat_id')->join('boat_tbl_category_tma', 'boat_tbl_category_tma.category_id', '=', 'boat_tbl_boat.boat_type_tma')->whereIn('boat_tbl_boat.marina', $marinasId)->where('boat_tbl_boat.status', 'y');

        if (!empty($numberGuests)) {
            $query->where('boat_tbl_boat.pax', '>', $numberGuests);
        } else {
            $query->where('boat_tbl_boat.pax', '>', 1);
        }

        if (!empty($boatCat)) {
            $query->where('boat_tbl_boat.boat_type_tma', $boatCat);
        }

        if ($priceOrder === 'asc') {
            $query->orderBy('btp.boatPrice', 'asc');
        } else {
            $query->orderBy('btp.boatPrice', 'desc');
        }

        return $query->get();
    }

    /**
     * Get boat details by its ID
     * @param $boatId
     * @return mixed
     */
    public function facilities($boatId)
    {
        $result = Facilitie::where('boat_id', $boatId)->first();
        // echo "<pre>";
        // print_r($result ? (object) $result->toArray() : null);
        // echo "</pre>";
        return $result ? (object) $result->getAttributes() : null;
    }

    /**
     * Get boat details based on boat type
     *
     * @param int $boatId
     * @return array
     */
    public function getBoatDetail($boatId)
    {
        $query = DB::table('boat_tbl_boat AS bo')
            ->leftJoinSub(function ($join) use ($boatId) {
                $join->select(
                    'btp.boat_id AS boatId',
                    'btp.currency',
                    DB::raw('MIN(NULLIF(btp.price, 0)) AS boatPrice')
                )
                    ->from('boat_time_price AS btp')
                    ->join('boat_tbl_boat AS bo2', function ($join) {
                        $join->on('btp.boat_id', '=', 'bo2.boat_id')
                            ->where('btp.date_for', '>=', DB::raw('NOW()'));
                    })
                    ->where('btp.boat_id', $boatId)
                    ->groupBy('btp.currency');
            }, 'btp', function ($join) {
                $join->on('btp.boatId', '=', 'bo.boat_id');
            })
            ->leftJoin('boat_marinas AS bm', 'bo.marina', '=', 'bm.marinas_id')
            ->leftJoin('tma_facilities AS tma', 'tma.boat_id', '=', 'bo.boat_id')
            ->select(
                'bo.*',
                'btp.currency',
                'btp.boatPrice',
                'bo.book_type',
                'bo.credit_available',
                'bm.marinas_name',
                'bm.country AS marinas_country',
                'tma.air_conditioning',
                'tma.shower',
                'tma.toilet',
                'tma.jet_skis',
                'tma.karaoke',
                'tma.cooler_boxes',
                'tma.kayak',
                'tma.standup_paddle',
                'tma.bbq_pit',
                'tma.tender',
                'tma.chiller',
                'tma.wifi',
                'tma.microwave',
                'tma.jacuzzi',
                'tma.water_donut',
                'tma.sound_system'
            )
            ->where('bo.boat_id', $boatId)
            ->where('bo.status', 'y');

        return $query->get()->toArray();
    }

    /**
     * Get one boat before current boat id tma
     *
     * @param int $currentBoatId
     * @param int $boatType
     * @return int|null
     */
    public function getBoatIdBeforeTma($currentBoatId, $boatType)
    {
        $result = DB::table('boat_tbl_boat')
            ->select('boat_id')
            ->where('boat_id', '<', $currentBoatId)
            ->where('boat_type_tma', $boatType)
            ->orderBy('boat_id', 'DESC')
            ->limit(1)
            ->value('boat_id');

        return $result;
    }

    /**
     * Get one boat after current boat id tma
     *
     * @param int $currentBoatId
     * @param int $boatType
     * @return int|null
     */
    public function getBoatIdAfterTma($currentBoatId, $boatType)
    {
        $result = DB::table('boat_tbl_boat')
            ->select('boat_id')
            ->where('boat_id', '>', $currentBoatId)
            ->where('boat_type_tma', $boatType)
            ->orderBy('boat_id', 'ASC')
            ->limit(1)
            ->value('boat_id');

        return $result;
    }
}
