<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatCountry
 *
 * @ORM\Table(name="boat_country")
 * @ORM\Entity
 */
class BoatCountry
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=true)
     */
    private $name = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="uc", type="string", length=20, nullable=true)
     */
    private $uc = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="posi", type="integer", nullable=false)
     */
    private $posi = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="tax_amount", type="string", length=20, nullable=false)
     */
    private $taxAmount;


}

