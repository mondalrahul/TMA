<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblArticle
 *
 * @ORM\Table(name="boat_tbl_article")
 * @ORM\Entity
 */
class BoatTblArticle
{
    /**
     * @var integer
     *
     * @ORM\Column(name="article_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $articleId;

    /**
     * @var string
     *
     * @ORM\Column(name="article", type="text", length=65535, nullable=false)
     */
    private $article;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="datetime", nullable=false)
     */
    private $addDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="cat_id", type="integer", nullable=false)
     */
    private $catId;

    /**
     * @var integer
     *
     * @ORM\Column(name="dis_cat", type="integer", nullable=false)
     */
    private $disCat;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_reply", type="integer", nullable=false)
     */
    private $totalReply;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=2, nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_views", type="integer", nullable=false)
     */
    private $totalViews;

    /**
     * @var string
     *
     * @ORM\Column(name="article_title", type="text", length=65535, nullable=false)
     */
    private $articleTitle;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent", type="integer", nullable=false)
     */
    private $parent;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="integer", nullable=false)
     */
    private $rate;

    /**
     * @var integer
     *
     * @ORM\Column(name="abuse", type="integer", nullable=false)
     */
    private $abuse;


}

