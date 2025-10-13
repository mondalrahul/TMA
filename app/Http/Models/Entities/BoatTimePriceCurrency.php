<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTimePriceCurrency
 *
 * @ORM\Table(name="boat_time_price_currency")
 * @ORM\Entity
 */
class BoatTimePriceCurrency
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
     * @ORM\Column(name="boat_time_price_id", type="integer", nullable=false)
     */
    private $boatTimePriceId;

    /**
     * @var string
     *
     * @ORM\Column(name="country_name", type="string", length=250, nullable=false)
     */
    private $countryName;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $skipper;

    /**
     * @var string
     *
     * @ORM\Column(name="excess", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $excess;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt = 'current_timestamp()';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt = 'current_timestamp()';


}

