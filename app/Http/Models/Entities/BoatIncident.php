<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatIncident
 *
 * @ORM\Table(name="boat_incident")
 * @ORM\Entity
 */
class BoatIncident
{
    /**
     * @var integer
     *
     * @ORM\Column(name="incident_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $incidentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="boat_id", type="integer", nullable=false)
     */
    private $boatId;

    /**
     * @var string
     *
     * @ORM\Column(name="charter_fault", type="text", length=65535, nullable=false)
     */
    private $charterFault;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="cost_type", type="string", length=200, nullable=false)
     */
    private $costType;

    /**
     * @var string
     *
     * @ORM\Column(name="incident_description", type="text", length=65535, nullable=false)
     */
    private $incidentDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="incident_date", type="date", nullable=false)
     */
    private $incidentDate;

    /**
     * @var string
     *
     * @ORM\Column(name="incident_location", type="text", length=65535, nullable=false)
     */
    private $incidentLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="text", length=65535, nullable=false)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=200, nullable=false)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_name", type="string", length=200, nullable=false)
     */
    private $boatName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="order_id", type="integer", nullable=false)
     */
    private $orderId;


}

