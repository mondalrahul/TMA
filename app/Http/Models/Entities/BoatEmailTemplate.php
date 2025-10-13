<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatEmailTemplate
 *
 * @ORM\Table(name="boat_email_template")
 * @ORM\Entity
 */
class BoatEmailTemplate
{
    /**
     * @var integer
     *
     * @ORM\Column(name="template", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $template;

    /**
     * @var string
     *
     * @ORM\Column(name="registration_email", type="text", nullable=false)
     */
    private $registrationEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="reviews_email", type="text", nullable=false)
     */
    private $reviewsEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="email_header", type="text", nullable=false)
     */
    private $emailHeader;

    /**
     * @var string
     *
     * @ORM\Column(name="email_footer", type="text", nullable=false)
     */
    private $emailFooter;

    /**
     * @var string
     *
     * @ORM\Column(name="wishlist_email", type="text", nullable=false)
     */
    private $wishlistEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="request_email", type="text", nullable=false)
     */
    private $requestEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="registration_email_subject", type="string", length=200, nullable=false)
     */
    private $registrationEmailSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="reviews_email_subject", type="string", length=200, nullable=false)
     */
    private $reviewsEmailSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="wishlist_email_subject", type="string", length=200, nullable=false)
     */
    private $wishlistEmailSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="request_email_subject", type="string", length=200, nullable=false)
     */
    private $requestEmailSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_notification", type="text", length=65535, nullable=false)
     */
    private $paymentNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_submission", type="text", length=65535, nullable=false)
     */
    private $boatSubmission;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_notification_subject", type="string", length=200, nullable=false)
     */
    private $paymentNotificationSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_submission_subject", type="string", length=200, nullable=false)
     */
    private $boatSubmissionSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_details_template", type="text", length=65535, nullable=true)
     */
    private $bankDetailsTemplate = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="bank_details_template_subject", type="string", length=200, nullable=true)
     */
    private $bankDetailsTemplateSubject = 'NULL';


}

