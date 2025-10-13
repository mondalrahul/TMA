<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblBookTiming
 *
 * @ORM\Table(name="boat_tbl_book_timing")
 * @ORM\Entity
 */
class BoatTblBookTiming
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_id", type="integer", nullable=false)
     */
    private $timeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="boat_id", type="integer", nullable=false)
     */
    private $boatId;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_from", type="integer", nullable=false)
     */
    private $timeFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="time_to", type="string", length=10, nullable=false)
     */
    private $timeTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_book", type="date", nullable=false)
     */
    private $dateBook;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

     /**
     * @var integer
     *
     * @ORM\Column(name="is_cancel", type="integer", nullable=false)
     */
    private $isCancel;

    /**
     * @var string
     *
     * @ORM\Column(name="booktime", type="string", length=20, nullable=false)
     */
    private $booktime;

    /**
     * @var integer
     *
     * @ORM\Column(name="booked_id", type="integer", nullable=false)
     */
    private $bookedId;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $timeId
     * @return BoatTblBookTiming
     */
    public function setTimeId($timeId)
    {
        $this->timeId = $timeId;

        return $this;
    }

    /**
     * @return integer
     */
    public function getTimeId()
    {
        return $this->timeId;
    }

    /**
     * @param integer $boatId
     * @return BoatTblBookTiming
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
     * @param integer $timeFrom
     * @return BoatTblBookTiming
     */
    public function setTimeFrom($timeFrom)
    {
        $this->timeFrom = $timeFrom;

        return $this;
    }

    /**
     * @return integer
     */
    public function getTimeFrom()
    {
        return $this->timeFrom;
    }

    /**
     * @param integer $timeTo
     * @return BoatTblBookTiming
     */
    public function setTimeTo($timeTo)
    {
        $this->timeTo = $timeTo;

        return $this;
    }

    /**
     * @return integer
     */
    public function getTimeTo()
    {
        return $this->timeTo;
    }

    /**
     * @param \DateTime $dateBook
     * @return BoatTblBookTiming
     */
    public function setDateBook($dateBook)
    {
        $this->dateBook = $dateBook;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateBook()
    {
        return $this->dateBook;
    }

    /**
     * @param \DateTime $addDate
     * @return BoatTblBookTiming
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
     * @param integer $userId
     * @return BoatTblBookTiming
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
     * @param integer $price
     * @return BoatTblBookTiming
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param integer $type
     * @return BoatTblBookTiming
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param integer $type
     * @return BoatTblBookTiming
     */
    public function setIsCancel($isCancel)
    {
        $this->isCancel = $isCancel;

        return $this;
    }

    /**
     * @return integer
     */
    public function getIsCancel()
    {
        return $this->isCancel;
    }

    /**
     * @param integer $bookTime
     * @return BoatTblBookTiming
     */
    public function setBookTime($bookTime)
    {
        $this->booktime = $bookTime;

        return $this;
    }

    /**
     * @return integer
     */
    public function getBookTime()
    {
        return $this->booktime;
    }

    /**
     * @param integer $bookedId
     * @return BoatTblBookTiming
     */
    public function setBookedId($bookedId)
    {
        $this->bookedId = $bookedId;

        return $this;
    }

    /**
     * @return integer
     */
    public function getBookedId()
    {
        return $this->bookedId;
    }
}

