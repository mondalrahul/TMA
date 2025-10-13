<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * TmaFacilities
 *
 * @ORM\Table(name="tma_facilities")
 * @ORM\Entity
 */
class TmaFacilities
{
    /**
     * @var integer
     *
     * @ORM\Column(name="boat_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $boatId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="air_conditioning", type="boolean", nullable=false)
     */
    private $airConditioning = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="shower", type="boolean", nullable=false)
     */
    private $shower = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="toilet", type="boolean", nullable=false)
     */
    private $toilet = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="jet_skis", type="boolean", nullable=false)
     */
    private $jetSkis = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="karaoke", type="boolean", nullable=false)
     */
    private $karaoke = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="cooler_boxes", type="boolean", nullable=false)
     */
    private $coolerBoxes = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="kayak", type="boolean", nullable=false)
     */
    private $kayak = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="standup_paddle", type="boolean", nullable=false)
     */
    private $standupPaddle = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="bbq_pit", type="boolean", nullable=false)
     */
    private $bbqPit = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="tender", type="boolean", nullable=false)
     */
    private $tender = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="chiller", type="boolean", nullable=false)
     */
    private $chiller = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="wifi", type="boolean", nullable=false)
     */
    private $wifi = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="microwave", type="boolean", nullable=false)
     */
    private $microwave = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="jacuzzi", type="boolean", nullable=false)
     */
    private $jacuzzi = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="water_donut", type="boolean", nullable=false)
     */
    private $waterDonut = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="sound_system", type="boolean", nullable=false)
     */
    private $soundSystem = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt = 'current_timestamp()';


}

