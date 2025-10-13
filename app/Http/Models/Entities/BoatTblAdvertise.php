<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblAdvertise
 *
 * @ORM\Table(name="boat_tbl_advertise")
 * @ORM\Entity
 */
class BoatTblAdvertise
{
    /**
     * @var integer
     *
     * @ORM\Column(name="add_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $addId;

    /**
     * @var string
     *
     * @ORM\Column(name="add_for", type="string", length=200, nullable=false)
     */
    private $addFor;

    /**
     * @var string
     *
     * @ORM\Column(name="add_details", type="text", length=65535, nullable=false)
     */
    private $addDetails;

    /**
     * @var integer
     *
     * @ORM\Column(name="add_pageid", type="integer", nullable=false)
     */
    private $addPageid;

    /**
     * @var integer
     *
     * @ORM\Column(name="add_rank", type="integer", nullable=false)
     */
    private $addRank;

    /**
     * @var string
     *
     * @ORM\Column(name="add_link", type="text", length=65535, nullable=false)
     */
    private $addLink;

    /**
     * @var string
     *
     * @ORM\Column(name="photoalt", type="string", length=200, nullable=false)
     */
    private $photoalt;


}

