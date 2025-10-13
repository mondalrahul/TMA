<?php
namespace App\Http\Models\Logics;

use App\Http\Traits\LogicDbTrait;
use function foo\func;
use function GuzzleHttp\Promise\promise_for;
use Illuminate\Support\Facades\DB;

class BoatTimePriceLogic
{
    use LogicDbTrait;

    /**
     * Get all data boat time price base on date and boat_id
     *
     * @param date $dateFor
     * @param int $boatId
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getDataBaseOnDateAndBoat($dateFor, $boatId)
    {
        return $this->readDb(function($manager, $conn) use ($dateFor, $boatId) {
            $query = $manager->createQueryBuilder();
            $query->select('btp.id, btp.timeId, btp.dateFor, btp.price, btp.timeFrom, btp.timeTo, btp.boatId, btp.excessDeposit, btp.skipperPrice, btp.currency')
                ->from('App\Http\Models\Entities\BoatTimePrice', 'btp')
                ->where($query->expr()->eq('btp.boatId', ':boatId'))
                ->andWhere($query->expr()->eq('btp.dateFor', ':dateFor'))
                ->orderBy('btp.id', 'DESC')
                ->setParameters(['dateFor' => $dateFor, 'boatId' => $boatId]);
            return $query->getQuery()->getArrayResult();
        });
    }

    /**
     * Get data boat time price base on boat_id : has max date_for
     *
     * @param int $boatId
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getDataBaseOnBoat($boatId)
    {
        return $this->readDb(function($manager, $conn) use ($boatId) {
            $query = $manager->createQueryBuilder();
            $query->select('btp.timeId, btp.dateFor, btp.price, btp.timeFrom, btp.timeTo, btp.boatId, btp.skipperPrice')
                ->from('App\Http\Models\Entities\BoatTimePrice', 'btp')
                ->where($query->expr()->eq('btp.boatId', ':boatId'))
                ->setParameter('boatId', $boatId);
            return $query->getQuery()->getSingleScalarResult();
        });
    }

    /**
     * Get single data boat time price
     *
     * @param int $boatId
     * @param date $dateFor
     * @param int $timeId
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getSingleDataBoatTimePrice($timeId, $dateFor, $boatId)
    {
        return $this->readDb(function($manager, $conn) use ($timeId, $dateFor, $boatId) {
            $query = $manager->createQueryBuilder();
            $query->select('btp.price, btp.skipperPrice')
                ->from('App\Http\Models\Entities\BoatTimePrice', 'btp')
                ->where($query->expr()->eq('btp.timeId', ':timeId'))
                ->andWhere($query->expr()->eq('btp.dateFor', ':dateFor'))
                ->andWhere($query->expr()->eq('btp.boatId', ':boatId'))
                ->setParameters(['timeId' => $timeId, 'dateFor' => $dateFor, 'boatId' => $boatId]);
            return $query->getQuery()->getSingleResult();
        });
    }

    /**
     * Get max date_for for a specific boat
     *
     * @param int $boatId
     * @return string
     * @author vduong daiduongptit090@gmail.com
     */
    public function getMaxDate($boatId)
    {
        return $this->readDb(function($manager, $conn) use ($boatId) {
            $query = $manager->createQueryBuilder();
            $query->select($query->expr()->max('btp.dateFor'))
                ->from('App\Http\Models\Entities\BoatTimePrice', 'btp')
                ->where($query->expr()->eq('btp.boatId', ':boatId'))
                ->setParameter('boatId', $boatId);
            return $query->getQuery()->getSingleScalarResult();
        });
    }

    /**
     * Get data boat time price when has country search
     *
     * @param int $boatId
     * @param decimal $price
     * @param string $country
     * @return string
     * @author vduong daiduongptit090@gmail.com
     */
    public function getMinPriceCurrency($boatId, $price, $country)
    {
        return $this->readDb(function($manager, $conn) use ($boatId, $price, $country) {
            $query = $manager->createQueryBuilder();
            $query->select($query->expr()->min('btpc.price'))
                ->from('App\Http\Models\Entities\BoatTimePrice', 'btp')
                ->leftJoin('App\Http\Models\Entities\BoatTimePriceCurrency', 'btpc', 'WITH', 'btp.id = btpc.boatTimePriceId')
                ->where($query->expr()->eq('btp.boatId', ':boatId'))
                ->andWhere($query->expr()->eq('btp.price', ':price'))
                ->andWhere($query->expr()->eq('btpc.countryName', ':countryName'))
                ->setParameters(['boatId' => $boatId, 'price' => $price, 'countryName' =>  $country]);
            return $query->getQuery()->getSingleScalarResult();
        });
    }

    /**
     * Get list range of specific boat
     *
     * @param int $boatId
     * @param datetime $dateStart
     * @param datetime $dateEnd
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getValidDateList($boatId, $dateStart, $dateEnd)
    {
        return $this->readDb(function($manager, $conn) use ($boatId, $dateStart, $dateEnd) {
            $query = $manager->createQueryBuilder();
            $query->select('btp.dateFor')
                ->from('App\Http\Models\Entities\BoatTimePrice', 'btp')
                ->where($query->expr()->eq('btp.boatId', ':boatId'))
                ->andWhere($query->expr()->gte('btp.dateFor', ':dateStart'))
                ->andWhere($query->expr()->lte('btp.dateFor', ':dateEnd'))
                ->groupBy('btp.dateFor')
                ->setParameters(['boatId' => $boatId, 'dateStart' => $dateStart, 'dateEnd' =>  $dateEnd]);
            return $query->getQuery()->getArrayResult();
        });
    }
}
