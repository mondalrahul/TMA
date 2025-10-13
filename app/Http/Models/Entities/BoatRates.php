<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatRates
 *
 * @ORM\Table(name="boat_rates")
 * @ORM\Entity
 */
class BoatRates
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rate_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rateId;

    /**
     * @var string
     *
     * @ORM\Column(name="rate_title", type="string", length=200, nullable=false)
     */
    private $rateTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="rate_description", type="text", length=65535, nullable=false)
     */
    private $rateDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rate_form", type="date", nullable=false)
     */
    private $rateForm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rate_to", type="date", nullable=false)
     */
    private $rateTo;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $skipper;

    /**
     * @var string
     *
     * @ORM\Column(name="charter", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $charter;

    /**
     * @var string
     *
     * @ORM\Column(name="management", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $management;

    /**
     * @var string
     *
     * @ORM\Column(name="list_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $listPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=5, nullable=false)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="excess_deposit", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $excessDeposit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var string
     *
     * @ORM\Column(name="rate_type", type="string", length=20, nullable=false)
     */
    private $rateType;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_rate", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $skipperRate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=2, nullable=false)
     */
    private $status;


}

