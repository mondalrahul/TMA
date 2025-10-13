<?php
namespace App\Http\Models\Logics;

use App\Http\Traits\LogicDbTrait;

class BoatCountryLogic
{
    use LogicDbTrait;

    const DEFAULT_COUNTRIES = [
        'Singapore',
        'Antigua and Barbuda',
        'Indonesia',
        'Thailand'
    ];

    /**
     * Get default boat country
     * Singapore, Antigua and Barbuda, Indonesia, Thailand
     *
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getDefaultBoatCountry()
    {
        return $this->readDb(function ($manager, $conn) {
            $query = $manager->createQueryBuilder();
            $query->select('co')
                ->from('App\Http\Models\Entities\BoatCountry', 'co')
                ->where($query->expr()->in('co.name', self::DEFAULT_COUNTRIES));

            return $query->getQuery()->getArrayResult();
        });
    }

    /**
     * Get list of all country
     *
     * @return array
     */
    public function getAllCountry()
    {
        return $this->readDb(function ($manager, $conn) {
            $query = $manager->createQueryBuilder();
            $query->select('co')
                ->from('App\Http\Models\Entities\BoatCountry', 'co');

            return $query->getQuery()->getArrayResult();
        });
    }

    /**
     * Get detail country
     *
     * @param string $country
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getDetailCountry($country)
    {
        return $this->readDb(function ($manager, $conn) use ($country) {
            $query = $manager->createQueryBuilder();
            $query->select('co')
                ->from('App\Http\Models\Entities\BoatCountry', 'co')
                ->where($query->expr()->eq('co.name', ':country'))
                ->setParameter('country', $country);

            return $query->getQuery()->getArrayResult();
        });
    }
}