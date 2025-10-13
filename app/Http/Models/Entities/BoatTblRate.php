<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblRate
 *
 * @ORM\Table(name="boat_tbl_rate")
 * @ORM\Entity
 */
class BoatTblRate
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
     * @var integer
     *
     * @ORM\Column(name="rate", type="integer", nullable=false)
     */
    private $rate;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate_by", type="integer", nullable=false)
     */
    private $rateBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate_for", type="integer", nullable=false)
     */
    private $rateFor;

    /**
     * @var string
     *
     * @ORM\Column(name="rate_details", type="text", length=65535, nullable=false)
     */
    private $rateDetails;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="datetime", nullable=false)
     */
    private $addDate;

    /**
     * @var string
     *
     * @ORM\Column(name="rate_status", type="string", length=2, nullable=false)
     */
    private $rateStatus;


}

