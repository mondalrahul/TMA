<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatUser
 *
 * @ORM\Table(name="boat_user")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class BoatUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=250, nullable=false)
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=250, nullable=false)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=100, nullable=false)
     */
    private $userPassword;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_subscription", type="integer", nullable=false)
     */
    private $userSubscription;

    /**
     * @var string
     *
     * @ORM\Column(name="user_address", type="text", length=65535, nullable=false)
     */
    private $userAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="user_country", type="string", length=250, nullable=false)
     */
    private $userCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="user_city", type="string", length=250, nullable=false)
     */
    private $userCity;

    /**
     * @var string
     *
     * @ORM\Column(name="user_state", type="string", length=250, nullable=false)
     */
    private $userState;

    /**
     * @var string
     *
     * @ORM\Column(name="user_zip", type="string", length=10, nullable=false)
     */
    private $userZip;

    /**
     * @var string
     *
     * @ORM\Column(name="user_status", type="string", length=10, nullable=false)
     */
    private $userStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="user_phone", type="string", length=20, nullable=false)
     */
    private $userPhone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="date", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_type", type="integer", nullable=false)
     */
    private $userType;

    /**
     * @var integer
     *
     * @ORM\Column(name="discount", type="integer", nullable=false)
     */
    private $discount;

    /**
     * @var integer
     *
     * @ORM\Column(name="referrer_id", type="integer", nullable=false)
     */
    private $referrerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="newscheck", type="integer", nullable=false)
     */
    private $newscheck;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_pic", type="string", length=200, nullable=true)
     */
    private $profilePic;

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=50, nullable=true)
     */
    private $timezone = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="referrer", type="string", length=100, nullable=true)
     */
    private $referrer = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="remember_token", type="string", length=255, nullable=true)
     */
    private $rememberToken = 'NULL';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt = 'current_timestamp()';

    /**
     * Triggered on insert
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->addDate = new \DateTime('now');
        $this->dateUpdated = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * Triggered on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->dateUpdated = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @param string $name
     * @return BoatUser
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $userEmail
     * @return BoatUser
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * @param string $userName
     * @return BoatUser
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @param string $userPassword
     * @return BoatUser
     */
    public function setPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * @param int $userSubscription
     * @return BoatUser
     */
    public function setUserSubscription($userSubscription)
    {
        $this->userSubscription = $userSubscription;

        return $this;
    }

    /**
     * @param string $userAddress
     * @return BoatUser
     */
    public function setUserAddress($userAddress)
    {
        $this->userAddress = $userAddress;

        return $this;
    }

    /**
     * @param string $userCountry
     * @return BoatUser
     */
    public function setUserCountry($userCountry)
    {
        $this->userCountry = $userCountry;

        return $this;
    }

    /**
     * @param string $userState
     * @return BoatUser
     */
    public function setUserState($userState)
    {
        $this->userState = $userState;

        return $this;
    }

    /**
     * @param string $userZip
     * @return BoatUser
     */
    public function setUserZip($userZip)
    {
        $this->userZip = $userZip;

        return $this;
    }

    /**
     * @param int $userType
     * @return BoatUser
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * @param string $userStatus
     * @return BoatUser
     */
    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;

        return $this;
    }

    /**
     * @param string $userPhone
     * @return BoatUser
     */
    public function setUserPhone($userPhone)
    {
        $this->userPhone = $userPhone;

        return $this;
    }

    /**
     * @param string $userCity
     * @return BoatUser
     */
    public function setUserCity($userCity)
    {
        $this->userCity = $userCity;

        return $this;
    }

    /**
     * @param string $timezone
     * @return BoatUser
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * @param int $referrerId
     * @return BoatUser
     */
    public function setReferrerId($referrerId)
    {
        $this->referrerId = $referrerId;

        return $this;
    }

    /**
     * @param string $referrer
     * @return BoatUser
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * @param string $rememberToken
     * @return BoatUser
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    /**
     * @param string $profilePic
     * @return BoatUser
     */
    public function setProfilePic($profilePic)
    {
        $this->profilePic = $profilePic;

        return $this;
    }

    /**
     * @param int $newscheck
     * @return BoatUser
     */
    public function setNewscheck($newscheck)
    {
        $this->newscheck = $newscheck;

        return $this;
    }

    /**
     * @param int $discount
     * @return BoatUser
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param \DateTime $lastLogin
     * @return BoatUser
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

}

