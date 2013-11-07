<?php


namespace JS\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JS\DefaultBundle\Entity\Product;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Order
 *
 * @ORM\Table(name="js_orders")
 * @ORM\Entity(repositoryClass="JS\DefaultBundle\Repository\OrderRepository")
 */
class Order {
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="JS\DefaultBundle\Entity\Product")
     * @ORM\JoinTable(name="js_orders_products",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id", unique=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", unique=false)}
     *      )
     */
    protected $products;

    /**
     * @var string
     * @ORM\Column(name="customer_name", type="string")
     */
    protected $customerName;

    /**
     * @var string
     * @ORM\Column(name="customer_address", type="string")
     */
    protected $customerAddress;

    /**
     * @var string
     * @ORM\Column(name="customer_telephone", type="string")
     */
    protected $customerTelephone;

    /**
     * @var string
     * @ORM\Column(name="customer_city", type="string")
     */
    protected $customerCity;

    /**
     * @var string
     * @ORM\Column(name="customer_email", type="string")
     */
    protected $customerEmail;

    /**
     * @var string
     * @ORM\Column(name="customer_country", type="string")
     */
    protected $customerCountry;

    /**
     * @var datetime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     * @return Order
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
    
        return $this;
    }

    /**
     * Get customerName
     *
     * @return string 
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set customerAddress
     *
     * @param string $customerAddress
     * @return Order
     */
    public function setCustomerAddress($customerAddress)
    {
        $this->customerAddress = $customerAddress;
    
        return $this;
    }

    /**
     * Get customerAddress
     *
     * @return string 
     */
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * Set customerTelephone
     *
     * @param string $customerTelephone
     * @return Order
     */
    public function setCustomerTelephone($customerTelephone)
    {
        $this->customerTelephone = $customerTelephone;
    
        return $this;
    }

    /**
     * Get customerTelephone
     *
     * @return string 
     */
    public function getCustomerTelephone()
    {
        return $this->customerTelephone;
    }

    /**
     * Set customerCity
     *
     * @param string $customerCity
     * @return Order
     */
    public function setCustomerCity($customerCity)
    {
        $this->customerCity = $customerCity;
    
        return $this;
    }

    /**
     * Get customerCity
     *
     * @return string 
     */
    public function getCustomerCity()
    {
        return $this->customerCity;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     * @return Order
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
     * Set customerCountry
     *
     * @param string $customerCountry
     * @return Order
     */
    public function setCustomerCountry($customerCountry)
    {
        $this->customerCountry = $customerCountry;
    
        return $this;
    }

    /**
     * Get customerCountry
     *
     * @return string 
     */
    public function getCustomerCountry()
    {
        return $this->customerCountry;
    }

    
    /**
     * Add products
     *
     * @param Product $products
     * @return Order
     */
    public function addProduct(Product $products)
    {
        $this->products[] = $products;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param Product $products
     */
    public function removeProduct(Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Order
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
}