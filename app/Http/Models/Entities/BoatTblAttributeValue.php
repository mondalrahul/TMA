<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblAttributeValue
 *
 * @ORM\Table(name="boat_tbl_attribute_value")
 * @ORM\Entity
 */
class BoatTblAttributeValue
{
    /**
     * @var integer
     *
     * @ORM\Column(name="value_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $valueId;

    /**
     * @var integer
     *
     * @ORM\Column(name="attribute_id", type="integer", nullable=false)
     */
    private $attributeId;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_name", type="text", length=65535, nullable=false)
     */
    private $attributeName;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_value", type="text", length=65535, nullable=false)
     */
    private $attributeValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="attribute_type", type="integer", nullable=false)
     */
    private $attributeType;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_for", type="string", length=20, nullable=false)
     */
    private $attributeFor;


}

