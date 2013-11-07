<?php


namespace JS\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Category
 *
 * @ORM\Table(name="js_category")
 * @ORM\Entity(repositoryClass="JS\DefaultBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=255)
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    protected $slug;

    /**
     * @ORM\OneToMany(targetEntity="JS\DefaultBundle\Entity\Product", mappedBy="category")
     */
    protected $products;

    /**
     * @var text
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var integer
     * @ORM\Column(name="usd_price", type="integer")
     */
    protected $usdPrice;

    /**
     * @var integer
     * @ORM\Column(name="byr_price", type="integer")
     */
    protected $byrPrice;

    /**
     * @var integer
     * @ORM\Column(name="rub_price", type="integer")
     */
    protected $rubPrice;

    /**
     * @var boolean
     * @ORM\Column(name="is_notebook", type="boolean")
     */
    protected $isNotebook;

    /**
     * @var integer
     * @ORM\Column(name="notebook_size", type="integer", nullable=true)
     */
    protected $notebookSize;

    /**
     * @var string
     * @ORM\Column(length=255)
     */
    protected $size;

    /**
     * @var string
     * @ORM\Column(length=255)
     */
    protected $material;

    /**
     * @var integer
     * @ORM\Column(name="weight", type="integer")
     */
    protected $weight;

    /**
     * @var string
     * @ORM\Column(length=255)
     */
    protected $capacity;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * String
     */
    public function  __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add products
     *
     * @param \JS\DefaultBundle\Entity\Product $products
     * @return Category
     */
    public function addProduct(\JS\DefaultBundle\Entity\Product $products)
    {
        $this->products[] = $products;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param \JS\DefaultBundle\Entity\Product $products
     */
    public function removeProduct(\JS\DefaultBundle\Entity\Product $products)
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
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set usdPrice
     *
     * @param integer $usdPrice
     * @return Category
     */
    public function setUsdPrice($usdPrice)
    {
        $this->usdPrice = $usdPrice;
    
        return $this;
    }

    /**
     * Get usdPrice
     *
     * @return integer 
     */
    public function getUsdPrice()
    {
        return $this->usdPrice;
    }

    /**
     * Set byrPrice
     *
     * @param integer $byrPrice
     * @return Category
     */
    public function setByrPrice($byrPrice)
    {
        $this->byrPrice = $byrPrice;
    
        return $this;
    }

    /**
     * Get byrPrice
     *
     * @return integer 
     */
    public function getByrPrice()
    {
        return $this->byrPrice;
    }

    /**
     * Set rubPrice
     *
     * @param integer $rubPrice
     * @return Category
     */
    public function setRubPrice($rubPrice)
    {
        $this->rubPrice = $rubPrice;
    
        return $this;
    }

    /**
     * Get rubPrice
     *
     * @return integer 
     */
    public function getRubPrice()
    {
        return $this->rubPrice;
    }

    /**
     * Set isNotebook
     *
     * @param boolean $isNotebook
     * @return Category
     */
    public function setIsNotebook($isNotebook = false)
    {
        $this->isNotebook = $isNotebook;
    
        return $this;
    }

    /**
     * Get isNotebook
     *
     * @return boolean 
     */
    public function getIsNotebook()
    {
        return $this->isNotebook;
    }

    /**
     * Set notebookSize
     *
     * @param integer $notebookSize
     * @return Category
     */
    public function setNotebookSize($notebookSize = null)
    {
        $this->notebookSize = $notebookSize;
    
        return $this;
    }

    /**
     * Get notebookSize
     *
     * @return integer 
     */
    public function getNotebookSize()
    {
        return $this->notebookSize;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return Category
     */
    public function setSize($size)
    {
        $this->size = $size;
    
        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set material
     *
     * @param string $material
     * @return Category
     */
    public function setMaterial($material)
    {
        $this->material = $material;
    
        return $this;
    }

    /**
     * Get material
     *
     * @return string 
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return Category
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    
        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     * @return Category
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    
        return $this;
    }

    /**
     * Get capacity
     *
     * @return string
     */
    public function getCapacity()
    {
        return $this->capacity;
    }
}