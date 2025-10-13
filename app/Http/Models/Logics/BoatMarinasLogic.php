<?php
namespace App\Http\Models\Logics;

use App\Http\Traits\LogicDbTrait;
use Illuminate\Support\Facades\DB;

class BoatMarinasLogic
{
    use LogicDbTrait;

    /**
     * Get marinas ids base on country
     *
     * @param string $marinasCountry
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getMarinasIds($marinasCountry)
    {
        return $this->readDb(function($manager, $conn) use ($marinasCountry) {
            $query = $manager->createQueryBuilder();
            $query->select('bm.marinasId')
                ->from('App\Http\Models\Entities\BoatMarinas', 'bm')
                ->where($query->expr()->eq('bm.country', ':country'))
                ->setParameter('country', $marinasCountry);

            return $query->getQuery()->getArrayResult();
        });
    }

    /**
     * Get marinas country base on id
     *
     * @param int $marinasId
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getMarinasCountry($marinasId)
    {
        return $this->readDb(function($manager, $conn) use ($marinasId) {
            $query = $manager->createQueryBuilder();
            $query->select('bm.country')
                ->from('App\Http\Models\Entities\BoatMarinas', 'bm')
                ->where($query->expr()->eq('bm.marinasId', ':marinasId'))
                ->setParameter('marinasId', $marinasId);

            return $query->getQuery()->getSingleScalarResult();
        });
    }

    /**
     * Get list of marinas based on status
     * @param $status
     * @return \Illuminate\Support\Collection
     */
    public function getMarinasByStatus($status)
    {
        return DB::table('boat_marinas')
            ->where('marinas_status', '=', $status)
            ->orderBy('marinas_name', 'asc')
            ->get();
    }
	public function getMarinasNameByID($id)
    {
        return DB::table('boat_marinas')
		    ->select('marinas_name')
            ->where('marinas_id', '=', $id)
            ->orderBy('marinas_name', 'asc')
            ->first();
    }
}
