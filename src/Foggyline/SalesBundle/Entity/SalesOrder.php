<?php

namespace Foggyline\SalesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalesOrder
 *
 * @ORM\Table(name="sales_order")
 * @ORM\Entity(repositoryClass="Foggyline\SalesBundle\Repository\SalesOrderRepository")
 */
class SalesOrder
{
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETE = 'complete';
    const STATUS_CANCELED = 'canceled';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


     /**
     * @ORM\ManyToOne(targetEntity="Foggyline\CustomerBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="items_price", type="decimal", precision=10, scale=0)
     */
    private $itemsPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="shipment_price", type="decimal", precision=10, scale=0)
     */
    private $shipmentPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="total_price", type="decimal", precision=10, scale=4)
     */
    private $totalPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_method", type="string", length=255)
     */
    private $paymentMethod;

    /**
     * @var string
     *
     * @ORM\Column(name="shipment_method", type="string", length=255)
     */
    private $shipmentMethod;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    private $modifiedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_email", type="string", length=255)
     */
    private $customerEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_first_name", type="string", length=255)
     */
    private $customerFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_last_name", type="string", length=255)
     */
    private $customerLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_first_name", type="string", length=255)
     */
    private $adressFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_last_name", type="string", length=255)
     */
    private $adressLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_country", type="string", length=255)
     */
    private $adressCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_state", type="string", length=255)
     */
    private $adressState;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_city", type="string", length=255)
     */
    private $adressCity;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_postcode", type="string", length=255)
     */
    private $adressPostcode;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_street", type="string", length=255)
     */
    private $adressStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_telephone", type="string", length=255)
     */
    private $adressTelephone;

    /**
     * 
     * @ORM\OneToMany(targetEntity="SalesOrderItem",mappedBy="salesOrder")
     */
    private $items;

     /**
     * @var string
     *
     * @ORM\Column(name="id_token", type="string", length=255)
     */
    private $idToken;
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();

    }
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
     * Set customer
     *
     * @param integer $customer
     *
     * @return SalesOrder
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

   /**
     * Get customer
     *
     * @return int
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set itemsPrice
     *
     * @param string $itemsPrice
     *
     * @return SalesOrder
     */
    public function setItemsPrice($itemsPrice)
    {
        $this->itemsPrice = $itemsPrice;

        return $this;
    }

    /**
     * Get itemsPrice
     *
     * @return string
     */
    public function getItemsPrice()
    {
        return $this->itemsPrice;
    }

    /**
     * Set shipmentPrice
     *
     * @param string $shipmentPrice
     *
     * @return SalesOrder
     */
    public function setShipmentPrice($shipmentPrice)
    {
        $this->shipmentPrice = $shipmentPrice;

        return $this;
    }

    /**
     * Get shipmentPrice
     *
     * @return string
     */
    public function getShipmentPrice()
    {
        return $this->shipmentPrice;
    }

    /**
     * Set totalPrice
     *
     * @param string $totalPrice
     *
     * @return SalesOrder
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return SalesOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     *
     * @return SalesOrder
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set shipmentMethod
     *
     * @param string $shipmentMethod
     *
     * @return SalesOrder
     */
    public function setShipmentMethod($shipmentMethod)
    {
        $this->shipmentMethod = $shipmentMethod;

        return $this;
    }

    /**
     * Get shipmentMethod
     *
     * @return string
     */
    public function getShipmentMethod()
    {
        return $this->shipmentMethod;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return SalesOrder
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     *
     * @return SalesOrder
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     *
     * @return SalesOrder
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * Get customerEmail
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Set customerFirstName
     *
     * @param string $customerFirstName
     *
     * @return SalesOrder
     */
    public function setCustomerFirstName($customerFirstName)
    {
        $this->customerFirstName = $customerFirstName;

        return $this;
    }

    /**
     * Get customerFirstName
     *
     * @return string
     */
    public function getCustomerFirstName()
    {
        return $this->customerFirstName;
    }

    /**
     * Set customerLastName
     *
     * @param string $customerLastName
     *
     * @return SalesOrder
     */
    public function setCustomerLastName($customerLastName)
    {
        $this->customerLastName = $customerLastName;

        return $this;
    }

    /**
     * Get customerLastName
     *
     * @return string
     */
    public function getCustomerLastName()
    {
        return $this->customerLastName;
    }

    /**
     * Set adressFirstName
     *
     * @param string $adressFirstName
     *
     * @return SalesOrder
     */
    public function setAdressFirstName($adressFirstName)
    {
        $this->adressFirstName = $adressFirstName;

        return $this;
    }

    /**
     * Get adressFirstName
     *
     * @return string
     */
    public function getAdressFirstName()
    {
        return $this->adressFirstName;
    }

    /**
     * Set adressLastName
     *
     * @param string $adressLastName
     *
     * @return SalesOrder
     */
    public function setAdressLastName($adressLastName)
    {
        $this->adressLastName = $adressLastName;

        return $this;
    }

    /**
     * Get adressLastName
     *
     * @return string
     */
    public function getAdressLastName()
    {
        return $this->adressLastName;
    }

    /**
     * Set adressCountry
     *
     * @param string $adressCountry
     *
     * @return SalesOrder
     */
    public function setAdressCountry($adressCountry)
    {
        $this->adressCountry = $adressCountry;

        return $this;
    }

    /**
     * Get adressCountry
     *
     * @return string
     */
    public function getAdressCountry()
    {
        return $this->adressCountry;
    }

    /**
     * Set adressState
     *
     * @param string $adressState
     *
     * @return SalesOrder
     */
    public function setAdressState($adressState)
    {
        $this->adressState = $adressState;

        return $this;
    }

    /**
     * Get adressState
     *
     * @return string
     */
    public function getAdressState()
    {
        return $this->adressState;
    }

    /**
     * Set adressCity
     *
     * @param string $adressCity
     *
     * @return SalesOrder
     */
    public function setAdressCity($adressCity)
    {
        $this->adressCity = $adressCity;

        return $this;
    }

    /**
     * Get adressCity
     *
     * @return string
     */
    public function getAdressCity()
    {
        return $this->adressCity;
    }

    /**
     * Set adressPostcode
     *
     * @param string $adressPostcode
     *
     * @return SalesOrder
     */
    public function setAdressPostcode($adressPostcode)
    {
        $this->adressPostcode = $adressPostcode;

        return $this;
    }

    /**
     * Get adressPostcode
     *
     * @return string
     */
    public function getAdressPostcode()
    {
        return $this->adressPostcode;
    }

    /**
     * Set adressStreet
     *
     * @param string $adressStreet
     *
     * @return SalesOrder
     */
    public function setAdressStreet($adressStreet)
    {
        $this->adressStreet = $adressStreet;

        return $this;
    }

    /**
     * Get adressStreet
     *
     * @return string
     */
    public function getAdressStreet()
    {
        return $this->adressStreet;
    }

    /**
     * Set adressTelephone
     *
     * @param string $adressTelephone
     *
     * @return SalesOrder
     */
    public function setAdressTelephone($adressTelephone)
    {
        $this->adressTelephone = $adressTelephone;

        return $this;
    }

    /**
     * Get adressTelephone
     *
     * @return string
     */
    public function getAdressTelephone()
    {
        return $this->adressTelephone;
    }

    public function setIdToken($idToken)
    {
        $this->idToken = $idToken;
    }

    public function getIdToken()
    {
        return $this->idToken;
    }
    


}

