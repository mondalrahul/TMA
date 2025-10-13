<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblPoleResult
 *
 * @ORM\Table(name="boat_tbl_pole_result")
 * @ORM\Entity
 */
class BoatTblPoleResult
{
    /**
     * @var integer
     *
     * @ORM\Column(name="result_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $resultId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pole_id", type="integer", nullable=false)
     */
    private $poleId;

    /**
     * @var integer
     *
     * @ORM\Column(name="answer_id", type="integer", nullable=false)
     */
    private $answerId;

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
     * @var string
     *
     * @ORM\Column(name="pole_from", type="string", length=30, nullable=false)
     */
    private $poleFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="pole_form_user", type="string", length=200, nullable=false)
     */
    private $poleFormUser;


}

