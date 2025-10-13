<?php
namespace App\Http\Models\Logics;

use App\Http\Traits\LogicDbTrait;

class BoatSeaSportsLogic
{
    use LogicDbTrait;

    /**
     * Get all charter sea sports brochure
     *
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getSeaSportsList($boatid)
    {
        return $this->readDb(function($manager, $conn) use ($boatid )  {
            $query = $manager->createQueryBuilder();
            $query->select('bs')
                ->from('App\Http\Models\Entities\BoatSeasportsBrochure', 'bs')
                ->where($query->expr()->eq('bs.boat_id', ':boat_id'))
                ->setParameter('boat_id', $boatid);
           
            return $query->getQuery()->getArrayResult();
        });
    }

    /**
     * Get charter sea sports brochure base on ids
     *
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getSeaSportsListBaseOnIds($idLists)
    {
        return $this->readDb(function($manager, $conn) use ($idLists) {
            $query = <<<EOF
SELECT bs.*
FROM boat_seasports_brochure bs
WHERE bs.id IN (?)
ORDER BY bs.id ASC
EOF;
            $stm = $conn->executeQuery($query, [$idLists], array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY));
            return $stm->fetchAll();
        });
    }
}
