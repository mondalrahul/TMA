<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatCharterBook
 *
 * @ORM\Table(name="boat_charter_book")
 * @ORM\Entity
 */
class BoatCharterBook
{
    /**
     * @var integer
     *
     * @ORM\Column(name="book_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $bookId;

    /**
     * @var string
     *
     * @ORM\Column(name="total_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $totalPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="boat_id", type="integer", nullable=false)
     */
    private $boatId;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_booked", type="integer", nullable=false)
     */
    private $lastBooked;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="is_skiper", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $isSkiper;

    /**
     * @var string
     *
     * @ORM\Column(name="is_coupon", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $isCoupon;

    /**
     * @var string
     *
     * @ORM\Column(name="timing_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $timingPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="excess_deposit", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $excessDeposit;

    /**
     * @var string
     *
     * @ORM\Column(name="contract", type="text", length=65535, nullable=false)
     */
    private $contract;

    /**
     * @var string
     *
     * @ORM\Column(name="referrer_discount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $referrerDiscount;

    /**
     * @var string
     *
     * @ORM\Column(name="user_manager", type="string", length=20, nullable=false)
     */
    private $userManager;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_type", type="string", length=40, nullable=false)
     */
    private $paymentType;

    /**
     * @var integer
     *
     * @ORM\Column(name="ifskipper", type="integer", nullable=false)
     */
    private $ifskipper;

    /**
     * @var string
     *
     * @ORM\Column(name="user_extrainfo", type="text", length=65535, nullable=false)
     */
    private $userExtrainfo;

    /**
     * @var integer
     *
     * @ORM\Column(name="ratingyes", type="integer", nullable=false)
     */
    private $ratingyes;

    /**
     * @var string
     *
     * @ORM\Column(name="seasport_brochure", type="string", length=255, nullable=true)
     */
    private $seasportBrochure;

    /**
     * @param string $totalPrice
     * @return BoatCharterBook
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param integer $boatId
     * @return BoatCharterBook
     */
    public function setBoatId($boatId)
    {
        $this->boatId = $boatId;

        return $this;
    }

    /**
     * @return integer
     */
    public function getBoatId()
    {
        return $this->boatId;
    }

    /**
     * @param integer $lastBooked
     * @return BoatCharterBook
     */
    public function setLastBooked($lastBooked)
    {
        $this->lastBooked = $lastBooked;

        return $this;
    }

    /**
     * @return integer
     */
    public function getLastBooked()
    {
        return $this->lastBooked;
    }

    /**
     * @param integer $userId
     * @return BoatCharterBook
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param \DateTime $addDate
     * @return BoatCharterBook
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

    /**
     * @param integer $status
     * @return BoatCharterBook
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $isSkiper
     * @return BoatCharterBook
     */
    public function setIsSkiper($isSkiper)
    {
        $this->isSkiper = $isSkiper;

        return $this;
    }

    /**
     * @return string
     */
    public function getIsSkiper()
    {
        return $this->isSkiper;
    }

    /**
     * @param string $isCoupon
     * @return BoatCharterBook
     */
    public function setIsCoupon($isCoupon)
    {
        $this->isCoupon = $isCoupon;

        return $this;
    }

    /**
     * @return string
     */
    public function getIsCoupon()
    {
        return $this->isCoupon;
    }

    /**
     * @param string $timingPrice
     * @return BoatCharterBook
     */
    public function setTimingPrice($timingPrice)
    {
        $this->timingPrice = $timingPrice;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimingPrice()
    {
        return $this->isCoupon;
    }

    /**
     * @param string $comment
     * @return BoatCharterBook
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->isCoupon;
    }

    /**
     * @param string $excessDeposit
     * @return BoatCharterBook
     */
    public function setExcessDeposit($excessDeposit)
    {
        $this->excessDeposit = $excessDeposit;

        return $this;
    }

    /**
     * @return string
     */
    public function getExcessDeposit()
    {
        return $this->excessDeposit;
    }

    /**
     * @param string $contract
     * @return BoatCharterBook
     */
    public function setContract($contract)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * @return string
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * @param string $referrerDiscount
     * @return BoatCharterBook
     */
    public function setReferrerDiscount($referrerDiscount)
    {
        $this->referrerDiscount = $referrerDiscount;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferrerDiscount()
    {
        return $this->referrerDiscount;
    }

    /**
     * @param string $userManager
     * @return BoatCharterBook
     */
    public function setUserManager($userManager)
    {
        $this->userManager = $userManager;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserManager()
    {
        return $this->userManager;
    }

    /**
     * @param string $paymentType
     * @return BoatCharterBook
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param string $userExtrainfo
     * @return BoatCharterBook
     */
    public function setUserExtrainfo($userExtrainfo)
    {
        $this->userExtrainfo = $userExtrainfo;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserExtrainfo()
    {
        return $this->userExtrainfo;
    }

    /**
     * @param integer $ifskipper
     * @return BoatCharterBook
     */
    public function setIfskipper($ifskipper)
    {
        $this->ifskipper = $ifskipper;

        return $this;
    }

    /**
     * @return integer
     */
    public function getIfskipper()
    {
        return $this->ifskipper;
    }

    /**
     * @param integer $ratingyes
     * @return BoatCharterBook
     */
    public function setRatingyes($ratingyes)
    {
        $this->ratingyes = $ratingyes;

        return $this;
    }

    /**
     * @return integer
     */
    public function getRatingyes()
    {
        return $this->ratingyes;
    }
    /**
     * @param string $bookType
     * @return BoatCharterBook
     */
    public function setbookType($bookType)
    {
        $this->bookType = $bookType;

        return $this;
    }

    /**
     * @return string
     */
    public function getbookType()
    {
        return $this->bookType;
    }
    /**
     * @param string $seasportBrochure
     * @return BoatCharterBook
     */
    public function setSeasportBrochure($seasportBrochure)
    {
        $this->seasportBrochure = $seasportBrochure;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeasportBrochure()
    {
        return $this->seasportBrochure;
    }

    /**
     * @return integer
     */
    public function getBookId()
    {
        return $this->bookId;
    }
}

