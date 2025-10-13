<?php
namespace App\Http\Models\Logics;

use App\Http\Models\Entities\BoatNewsletter;
use App\Http\Traits\LogicDbTrait;

class BoatNewsLetterLogic
{
    use LogicDbTrait;

    const USER_SUBSCRIPTION = 1;
    const USER_NOT_SUBSCRIPTION = 0;
    const SALT_STRING = 'abchefghjkminpqrstuvwxyz0123456789';
    /**
     * Insert new data to table
     *
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getNewsLetter()
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
     * Check data exists
     *
     * @param string $email
     * @return boolean
     * @author vduong daiduongptit090@gmail.com
     */
    public function isEmailExists($email)
    {
        return $this->readDb(function ($manager, $conn) use ($email) {
            $query = $manager->createQueryBuilder();
            $query->select('nl.newsletterId')
                ->from('App\Http\Models\Entities\BoatNewsletter', 'nl')
                ->where($query->expr()->eq('nl.newsletterEmail', ':email'))
                ->setParameter('email', $email);

            $result = $query->getQuery()->getArrayResult();
            if (!empty($result)) {
                return true;
            }
            return false;
        });
    }

    /**
     * Update data
     *
     * @param string $email
     * @return int 0|1
     * @author vduong daiduongptit090@gmail.com
     */
    public function updateNewsLetter($email)
    {
        return $this->writeDb(function ($manager, $conn) use ($email) {
            // get unique id
            $uniqueId = $this->generateUniqueId();

            $query = $manager->createQueryBuilder();
            $query->update('App\Http\Models\Entities\BoatNewsletter', 'nl')
                ->set('nl.userSubscription', $query->expr()->literal(self::USER_SUBSCRIPTION))
                ->set('nl.uniqueId', $query->expr()->literal($uniqueId))
                ->where($query->expr()->eq('nl.newsletterEmail', ':email'))
                ->setParameter('email', $email);

            return $query->getQuery()->execute();
        });
    }

    /**
     * Update data
     *
     * @param string $email
     * @return int 0|1
     * @author vduong daiduongptit090@gmail.com
     */
    public function insertNewsLetter($email)
    {
        return $this->writeDb(function ($manager, $conn) use ($email) {
            // get unique id
            $uniqueId = $this->generateUniqueId();

            $boatNewsletter = new BoatNewsletter();
            $boatNewsletter->setUniqueId($uniqueId);
            $boatNewsletter->setUserSubscription(self::USER_SUBSCRIPTION);
            $boatNewsletter->setNewsletterEmail($email);

            $manager->persist($boatNewsletter);
            $manager->flush();
        });
    }

    /**
     * Create unique id
     *
     * @return string
     * @author vduong daiduongptit090@gmail.com
     */
    public function generateUniqueId()
    {
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = "";
        while ($i <= 4) {
            $num = rand() % 33;

            $tmp = substr(self::SALT_STRING, $num, 1);

            $pass = $pass . $tmp;
            $i++;
        }
        return strtoupper($pass);
    }
}