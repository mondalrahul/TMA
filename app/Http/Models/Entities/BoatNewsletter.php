<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatNewsletter
 *
 * @ORM\Table(name="boat_newsletter")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class BoatNewsletter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $newsletterId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_subscription", type="integer", nullable=false)
     */
    private $userSubscription;

    /**
     * @var string
     *
     * @ORM\Column(name="unique_id", type="string", length=200, nullable=true)
     */
    private $uniqueId = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="newsletter_email", type="string", length=200, nullable=false)
     */
    private $newsletterEmail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * Triggered on insert
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->addDate = new \DateTime('now');
    }

    /**
     * @param string $uniqueId
     * @return BoatNewsletter
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * @param int $userSubscription
     * @return BoatNewsletter
     */
    public function setUserSubscription($userSubscription)
    {
        $this->userSubscription = $userSubscription;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserSubscription()
    {
        return $this->userSubscription;
    }

    /**
     * @param string $newsletterEmail
     * @return BoatNewsletter
     */
    public function setNewsletterEmail($newsletterEmail)
    {
        $this->newsletterEmail = $newsletterEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getNewsletterEmail()
    {
        return $this->newsletterEmail;
    }

    /**
     * @param \DateTime $addDate
     * @return BoatNewsletter
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAddDate()
    {
        return $this->addDate;
    }
}

