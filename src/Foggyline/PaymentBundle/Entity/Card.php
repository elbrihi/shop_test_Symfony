<?php

namespace Foggyline\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card
 *
 * @ORM\Table(name="card")
 * @ORM\Entity(repositoryClass="Foggyline\PaymentBundle\Repository\CardRepository")
 */
class Card
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="card_type", type="string", length=255)
     */
    private $cardType;

    /**
     * @var string
     *
     * @ORM\Column(name="card_number", type="string", length=255)
     */
    private $cardNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expirty_date", type="datetime")
     */
    private $expirtyDate;

    /**
     * @var string
     *
     * @ORM\Column(name="security_code", type="string", length=255)
     */
    private $securityCode;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cardType
     *
     * @param string $cardType
     *
     * @return Card
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set cardNumber
     *
     * @param string $cardNumber
     *
     * @return Card
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set expirtyDate
     *
     * @param \DateTime $expirtyDate
     *
     * @return Card
     */
    public function setExpirtyDate($expirtyDate)
    {
        $this->expirtyDate = $expirtyDate;

        return $this;
    }

    /**
     * Get expirtyDate
     *
     * @return \DateTime
     */
    public function getExpirtyDate()
    {
        return $this->expirtyDate;
    }

    /**
     * Set securityCode
     *
     * @param string $securityCode
     *
     * @return Card
     */
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;

        return $this;
    }

    /**
     * Get securityCode
     *
     * @return string
     */
    public function getSecurityCode()
    {
        return $this->securityCode;
    }
}

