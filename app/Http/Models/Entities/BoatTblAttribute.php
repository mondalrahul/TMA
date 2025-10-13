<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblAttribute
 *
 * @ORM\Table(name="boat_tbl_attribute")
 * @ORM\Entity
 */
class BoatTblAttribute
{
    /**
     * @var integer
     *
     * @ORM\Column(name="attribute_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $attributeId;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_name", type="string", length=200, nullable=false)
     */
    private $attributeName;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_for", type="string", length=10, nullable=false)
     */
    private $attributeFor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="date", nullable=false)
     */
    private $dateCreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_update", type="date", nullable=false)
     */
    private $dateUpdate;


}

