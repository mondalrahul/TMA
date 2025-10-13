<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatHomeSliderTma
 *
 * @ORM\Table(name="boat_home_slider_tma")
 * @ORM\Entity
 */
class BoatHomeSliderTma
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
     * @ORM\Column(name="slider_name", type="string", length=255, nullable=false)
     */
    private $sliderName;

    /**
     * @var string
     *
     * @ORM\Column(name="slider_link", type="string", length=255, nullable=true)
     */
    private $sliderLink = 'NULL';

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="smallint", nullable=true)
     */
    private $duration = '3';

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

