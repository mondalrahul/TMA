<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatCoupon
 *
 * @ORM\Table(name="boat_coupon")
 * @ORM\Entity
 */
class BoatCoupon
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
     * @var string
     *
     * @ORM\Column(name="coupon", type="string", length=100, nullable=false)
     */
    private $coupon;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_use", type="integer", nullable=false)
     */
    private $maxUse;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="valid_from", type="date", nullable=false)
     */
    private $validFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="valid_to", type="date", nullable=false)
     */
    private $validTo;

    /**
     * @var string
     *
     * @ORM\Column(name="coupon_type", type="string", length=20, nullable=false)
     */
    private $couponType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="already_used", type="integer", nullable=false)
     */
    private $alreadyUsed;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=20, nullable=true)
     */
    private $country = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="cat_id", type="integer", nullable=false)
     */
    private $catId;

    /**
     * @var integer
     *
     * @ORM\Column(name="marina", type="integer", nullable=false)
     */
    private $marina;

    /**
     * @var string
     *
     * @ORM\Column(name="boats", type="text", length=65535, nullable=true)
     */
    private $boats = 'NULL';


}

