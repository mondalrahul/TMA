<?php

namespace App\Http\Models\Logics;

use App\Http\Traits\LogicDbTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoatLogic
{
    use LogicDbTrait;

    /**
     * Get all boat base on boat type
     *
     * @param int $boatTypeId
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getAllBoatsOfType($boatTypeId, $country = '', $priceOrder = 'asc')
    {
        $curdate = date('Y-m-d');
        return $this->readDb(function ($manager, $conn) use ($boatTypeId, $country, $priceOrder, $curdate) {
            $query = <<<EOF
SELECT bo.*, btp.currency, btp.boatPrice, boat_tbl_category_tma.category_name
FROM boat_tbl_boat bo
LEFT JOIN ( 
    SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price,0)) AS boatPrice 
    FROM boat_time_price btp
    INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id and  btp.date_for >= NOW() 
    GROUP BY btp.boat_id, btp.currency
) AS btp ON btp.boatId = bo.boat_id
INNER JOIN boat_tbl_category_tma ON boat_tbl_category_tma.category_id = bo.boat_type_tma
WHERE bo.boat_type_tma = :boatTypeId AND bo.status = 'y'
EOF;
            if (!empty($country)) {
                $query .= " AND bo.country = :country";
            }
            if ($priceOrder  === "nasc") {
                $query .= " ORDER BY bo.boat_type_tma ASC";
            } else {
                if ($priceOrder === 'asc') {
                    $query .= " ORDER BY btp.boatPrice ASC";
                } else {
                    $query .= " ORDER BY btp.boatPrice DESC";
                }
            }
            $stm = $conn->prepare($query);
            $stm->bindValue("boatTypeId", $boatTypeId);
            if (!empty($country)) {
                $stm->bindValue("country", $country);
            }

            $stm->execute();
            return $stm->getWrappedStatement();
            // dd($stm);
        });
    }

    /**
     * Get all boat base on boat type
     *
     * @param int $boatId
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getBoatDetail($boatId)
    {

        if ($boatId == '615') {
            return $this->readDb(function ($manager, $conn) use ($boatId) {
                $query = <<<EOF
SELECT bo.*, btp.currency, btp.boatPrice,bo.book_type,bo.credit_available, bm.marinas_name, bm.country AS marinas_country, tma.air_conditioning, tma.shower, tma.toilet, tma.jet_skis, tma.karaoke,tma.cooler_boxes, tma.kayak, tma.standup_paddle, tma.bbq_pit, tma.tender, tma.chiller, tma.wifi, tma.microwave, tma.jacuzzi, tma.water_donut, tma.sound_system
FROM boat_tbl_boat bo
LEFT JOIN ( 
    SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price,0)) AS boatPrice 
    FROM boat_time_price btp
    INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id and  btp.date_for >= NOW()
    WHERE btp.boat_id = :boatId
    GROUP BY btp.currency
) AS btp ON btp.boatId = bo.boat_id
LEFT JOIN boat_marinas bm ON bo.marina = bm.marinas_id
LEFT JOIN tma_facilities tma ON tma.boat_id = bo.boat_id
WHERE bo.boat_id = :boatId AND bo.status = 'y'
EOF;
                $stm = $conn->prepare($query);
                $stm->bindValue("boatId", $boatId);
                $stm->execute();
                return $stm->fetchAll();
            });
        } else {
            return $this->readDb(function ($manager, $conn) use ($boatId) {
                $query = <<<EOF
SELECT bo.*, btp.currency, btp.boatPrice, bm.marinas_name, bm.country AS marinas_country, tma.air_conditioning, tma.shower, tma.toilet, tma.jet_skis, tma.karaoke,tma.cooler_boxes, tma.kayak, tma.standup_paddle, tma.bbq_pit, tma.tender, tma.chiller, tma.wifi, tma.microwave, tma.jacuzzi, tma.water_donut, tma.sound_system
FROM boat_tbl_boat bo
LEFT JOIN ( 
    SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price,0)) AS boatPrice 
    FROM boat_time_price btp
    INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id and  btp.date_for >= NOW()
    WHERE btp.boat_id = :boatId
    GROUP BY btp.currency
) AS btp ON btp.boatId = bo.boat_id
LEFT JOIN boat_marinas bm ON bo.marina = bm.marinas_id
LEFT JOIN tma_facilities tma ON tma.boat_id = bo.boat_id
WHERE bo.boat_id = :boatId AND bo.status = 'y'
EOF;
                $stm = $conn->prepare($query);
                $stm->bindValue("boatId", $boatId);
                $stm->execute();
                return $stm->fetchAll();
            });
        }
    }

    /**
     * Get one boat before current boat id
     *
     * @param int $currentBoatId
     * @param int $boatType
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getBoatIdBefore($currentBoatId, $boatType)
    {
        return $this->readDb(function ($manager, $conn) use ($currentBoatId, $boatType) {
            $query = $manager->createQueryBuilder();
            $query->select('bo.boatId')
                ->from('App\Http\Models\Entities\BoatTblBoat', 'bo')
                ->where($query->expr()->lt('bo.boatId', ':curBoatId'))
                ->andWhere($query->expr()->eq('bo.boatType', ':boatType'))
                ->orderBy('bo.boatId', 'DESC')
                ->setParameters(['curBoatId' => $currentBoatId, 'boatType' => $boatType])
                ->setMaxResults(1);

            return $query->getQuery()->getSingleScalarResult();
        });
    }

    /**
     * Get one boat before current boat id tma
     *
     * @param int $currentBoatId
     * @param int $boatType
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getBoatIdBeforeTma($currentBoatId, $boatType)
    {
        return $this->readDb(function ($manager, $conn) use ($currentBoatId, $boatType) {
            $query = $manager->createQueryBuilder();
            $query->select('bo.boatId')
                ->from('App\Http\Models\Entities\BoatTblBoat', 'bo')
                ->where($query->expr()->lt('bo.boatId', ':curBoatId'))
                ->andWhere($query->expr()->eq('bo.boatTypeTma', ':boatType'))
                ->orderBy('bo.boatId', 'DESC')
                ->setParameters(['curBoatId' => $currentBoatId, 'boatType' => $boatType])
                ->setMaxResults(1);

            return $query->getQuery()->getSingleScalarResult();
        });
    }

    /**
     * Get one boat after current boat id
     *
     * @param int $currentBoatId
     * @param int $boatType
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getBoatIdAfter($currentBoatId, $boatType)
    {
        return $this->readDb(function ($manager, $conn) use ($currentBoatId, $boatType) {
            $query = $manager->createQueryBuilder();
            $query->select('bo.boatId')
                ->from('App\Http\Models\Entities\BoatTblBoat', 'bo')
                ->where($query->expr()->gt('bo.boatId', ':curBoatId'))
                ->andWhere($query->expr()->eq('bo.boatType', ':boatType'))
                ->orderBy('bo.boatId', 'ASC')
                ->setParameters(['curBoatId' => $currentBoatId, 'boatType' => $boatType])
                ->setMaxResults(1);

            return $query->getQuery()->getSingleScalarResult();
        });
    }

    /**
     * Get one boat after current boat id tma
     *
     * @param int $currentBoatId
     * @param int $boatType
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getBoatIdAfterTma($currentBoatId, $boatType)
    {
        return $this->readDb(function ($manager, $conn) use ($currentBoatId, $boatType) {
            $query = $manager->createQueryBuilder();
            $query->select('bo.boatId')
                ->from('App\Http\Models\Entities\BoatTblBoat', 'bo')
                ->where($query->expr()->gt('bo.boatId', ':curBoatId'))
                ->andWhere($query->expr()->eq('bo.boatTypeTma', ':boatType'))
                ->orderBy('bo.boatId', 'ASC')
                ->setParameters(['curBoatId' => $currentBoatId, 'boatType' => $boatType])
                ->setMaxResults(1);

            return $query->getQuery()->getSingleScalarResult();
        });
    }

    /**
     * Get all boat base on number guests, occasion, boat category, country
     *
     * @param int $numberGuests
     * @param string $occasion
     * @param int $boatCat
     * @param string $country default Singapore
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getAllBoatsByConditions($numberGuests, $occasion, $boatCat, $country, $priceOrder = 'asc')
    {
        return $this->readDb(function ($manager, $conn) use ($numberGuests, $occasion, $boatCat, $country, $priceOrder) {
            $query = <<<EOF
SELECT bo.*, btp.currency, btp.boatPrice, boat_tbl_category_tma.category_name
FROM boat_tbl_boat bo
LEFT JOIN ( 
    SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price,0)) AS boatPrice 
    FROM boat_time_price btp
    INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id and  btp.date_for >= NOW()
    GROUP BY btp.boat_id, btp.currency
) AS btp ON btp.boatId = bo.boat_id
INNER JOIN boat_tbl_category_tma ON boat_tbl_category_tma.category_id = bo.boat_type_tma
WHERE bo.status = 'y'
EOF;
            if (!empty($numberGuests)) {
                $query .= " AND bo.pax > :numGuests";
            } else {
                $query .= " AND bo.pax > 1";
            }
            if (!empty($boatCat)) {
                $query .= " AND bo.boat_type_tma = :boatCat";
            }
            if (!empty($country)) {
                $query .= " AND bo.country = :country";
            }
            if ($priceOrder === 'asc') {
                $query .= " ORDER BY btp.boatPrice ASC";
            } else {
                $query .= " ORDER BY btp.boatPrice DESC";
            }
            $stm = $conn->prepare($query);

            if (!empty($numberGuests)) {
                $stm->bindValue("numGuests", $numberGuests);
            }
            if (!empty($boatCat)) {
                $stm->bindValue("boatCat", $boatCat);
            }
            if (!empty($country)) {
                $stm->bindValue("country", $country);
            }

            $stm->execute();
            return $stm->fetchAll();
        });
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

    /**
     * Get all boat home base on marinas id
     *
     * @param array $marinasId
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getAllBoatHomeSameMarinas($numberGuests, $occasion, $boatCat, $marinasId, $priceOrder = 'asc')
    {
        return $this->readDb(function ($manager, $conn) use ($numberGuests, $occasion, $boatCat, $marinasId, $priceOrder) {
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
WHERE bo.marina IN (?) AND bo.status = 'y'
EOF;
            $replaceParams[] = $marinasId;
            if (!empty($numberGuests)) {
                $query .= " AND bo.pax > ?";
                $replaceParams[] = $numberGuests;
            } else {
                $query .= " AND bo.pax > 1";
            }
            if (!empty($boatCat)) {
                $query .= " AND bo.boat_type_tma = ?";
                $replaceParams[] = $boatCat;
            }
            if ($priceOrder === 'asc') {
                $query .= " ORDER BY btp.boatPrice ASC";
            } else {
                $query .= " ORDER BY btp.boatPrice DESC";
            }

            $countReplaceParams = count($replaceParams);
            if ($countReplaceParams === 3) {
                $stm = $conn->executeQuery($query, $replaceParams, array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY, \PDO::PARAM_INT, \PDO::PARAM_INT));
            } elseif ($countReplaceParams === 2) {
                $stm = $conn->executeQuery($query, $replaceParams, array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY, \PDO::PARAM_INT));
            } else {
                $stm = $conn->executeQuery($query, $replaceParams, array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY));
            }

            return $stm->fetchAll();
        });
    }

    /**
     * Get list boat of current user
     * @param null $boatName
     * @param null $marina
     * @param null $boatType
     * @param null $status
     * @param null $startWith
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getMyBoats($boatName = null, $marina = null, $boatType = null, $status = null, $startWith = null)
    {
        $query = DB::table('boat_tbl_boat')
            ->select(
                'boat_tbl_boat.boat_id',
                'boat_tbl_boat.boat_name',
                'boat_tbl_boat.country',
                'boat_tbl_boat.main_photo',
                'boat_tbl_boat.status',
                'boat_tbl_boat.add_date',
                'boat_tbl_boat.date_updated',
                'boat_tbl_category_tma.category_name',
                'boat_marinas.marinas_name'
            )
            ->leftJoin('boat_tbl_category_tma', 'boat_tbl_category_tma.category_id', '=', 'boat_tbl_boat.boat_type_tma')
            ->leftJoin('boat_marinas', 'boat_marinas.marinas_id', '=', 'boat_tbl_boat.marina')
            ->where('user_id', '=', Auth::id());

        if (!empty($boatName)) {
            $query = $query->where('boat_name', 'like', '%' . $boatName . '%');
        }

        if (!empty($marina)) {
            $query = $query->where('marina', '=', $marina);
        }

        if (!empty($boatType)) {
            $query = $query->where('boat_type_tma', '=', $boatType);
        }

        if (!empty($status)) {
            $query = $query->where('status', '=', $status);
        }

        if (!empty($startWith)) {
            $query = $query->where('boat_name', 'like', $startWith . '%');
        }

        $query = $query->orderBy('boat_id', 'desc');
        return $query->paginate(25);
    }

    /**
     * @return array
     */
    public function getMyBoatStatus()
    {
        $query = DB::table('boat_tbl_boat')
            ->select(
                'status',
                DB::raw('count(boat_id) as count')
            )
            ->groupBy('status')
            ->where('user_id', '=', Auth::id());

        $result = $query->get();
        $status = [
            'y' => 0,
            'n' => 0,
            'p' => 0
        ];

        $result->each(function ($row) use (&$status) {
            $status[$row->status] = $row->count;
        });

        return $status;
    }

    /**
     * Delete boat based by list of IDs
     * @param $boatsId
     */
    public function deleteBoatsById($boatsId)
    {
        DB::table('boat_tbl_boat')->whereIn('boat_id', $boatsId)->delete();
    }

    /**
     * Create new boat with a given data
     * @param $boatData
     */
    public function addBoats($boatData)
    {
        DB::table('boat_tbl_boat')->insert($boatData);
    }

    /**
     * Get boat details by its ID
     * @param $boatId
     * @return mixed
     */
    public function getBoatByID($boatId)
    {
        return DB::table('boat_tbl_boat')->where('boat_id', $boatId)->first();
    }
    /**
     * Get boat details by its ID
     * @param $boatId
     * @return mixed
     */
    public function facilities($boatId)
    {
        return DB::table('tma_facilities')->where('boat_id', $boatId)->first();
    }


    /**
     * Update boat detail by its ID
     * @param $boatId
     * @param $boatData
     * @return mixed
     */
    public function updateBoat($boatId, $boatData)
    {
        return DB::table('boat_tbl_boat')->where('boat_id', $boatId)->update($boatData);
    }

    /**
     * Get all boat created by a user by user ID
     * @param $userId
     * @return \Illuminate\Support\Collection
     */
    public function getBoatCreateBy($userId)
    {
        $sql = DB::table('boat_tbl_boat')->where('user_id', $userId);

        return $sql->get();
    }

    /**
     * Get all boat created by a user by current user
     * @return \Illuminate\Support\Collection
     */
    public function getBoatCreateByCurrentUser()
    {
        $userId = Auth::id();

        return $this->getBoatCreateBy($userId);
    }
}
