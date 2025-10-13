<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTimePrice
 *
 * @ORM\Table(name="boat_time_price")
 * @ORM\Entity
 */
class BoatTimePrice
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_for", type="date", nullable=false)
     */
    private $dateFor;

    /**
     * @var integer
     *
     * @ORM\Column(name="boat_id", type="integer", nullable=false)
     */
    private $boatId;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate_id", type="integer", nullable=false)
     */
    private $rateId;

    /**
     * @var string
     *
     * @ORM\Column(name="dayname", type="string", length=20, nullable=false)
     */
    private $dayname;

    /**
     * @var string
     *
     * @ORM\Column(name="excess_deposit", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $excessDeposit;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_from", type="integer", nullable=false)
     */
    private $timeFrom;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_to", type="integer", nullable=false)
     */
    private $timeTo;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $skipperPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="addtime", type="string", length=20, nullable=false)
     */
    private $addtime;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=5, nullable=true)
     */
    private $currency = 'NULL';

}

