<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblPoleAnswer
 *
 * @ORM\Table(name="boat_tbl_pole_answer")
 * @ORM\Entity
 */
class BoatTblPoleAnswer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="answer_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $answerId;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_value", type="text", length=65535, nullable=false)
     */
    private $answerValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="corect_incorrect", type="integer", nullable=false)
     */
    private $corectIncorrect;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="date", nullable=false)
     */
    private $dateCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="pole_id", type="integer", nullable=false)
     */
    private $poleId;


}

