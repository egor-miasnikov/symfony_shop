<?php


namespace JS\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JS\DefaultBundle\Entity\Article;
use JS\DefaultBundle\Entity\Category;
use Symfony\Component\HttpFoundation\File\File;


/**
 * Product
 *
 * @ORM\Table(name="js_products")
 * @ORM\Entity(repositoryClass="JS\DefaultBundle\Repository\ProductRepository")
 */
class Product {
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="JS\DefaultBundle\Entity\Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="cascade", nullable = false)
     */
    protected $article;

    /**
     * @ORM\ManyToOne(targetEntity="JS\DefaultBundle\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="cascade", nullable = false)
     */
    protected $category;

    /**
     * orders
     */
    protected $orders;


    /**
     * @var boolean
     * @ORM\Column(name="is_main", type="boolean")
     */
    protected $isMain;

    /**
     * @var boolean
     * @ORM\Column(name="is_hidden", type="boolean")
     */
    protected $isHidden;

    /**
     * @ORM\Column(length=255)
     */
    protected $image;

    protected $file;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Carusel
     */
    public function setFile(File $image = null)
    {
        $this->file = $image;

        return $this;
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
     * Set isMain
     *
     * @param boolean $isMain
     * @return Product
     */
    public function setIsMain($isMain = false)
    {
        $this->isMain = $isMain;
    
        return $this;
    }

    /**
     * Get isMain
     *
     * @return boolean 
     */
    public function getIsMain()
    {
        return $this->isMain;
    }

    /**
     * Set isHidden
     *
     * @param boolean $isHidden
     * @return Product
     */
    public function setIsHidden($isHidden = false)
    {
        $this->isHidden = $isHidden;
    
        return $this;
    }

    /**
     * Get isHidden
     *
     * @return boolean 
     */
    public function getIsHidden()
    {
        return $this->isHidden;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set article
     *
     * @param \JS\DefaultBundle\Entity\Article $article
     * @return Product
     */
    public function setArticle(\JS\DefaultBundle\Entity\Article $article)
    {
        $this->article = $article;
    
        return $this;
    }

    /**
     * Get article
     *
     * @return \JS\DefaultBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set category
     *
     * @param \JS\DefaultBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\JS\DefaultBundle\Entity\Category $category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \JS\DefaultBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }


    /**
     * Add orders
     *
     * @param \JS\DefaultBundle\Entity\Order $orders
     * @return Product
     */
    public function addOrder(\JS\DefaultBundle\Entity\Order $orders)
    {
        $this->orders[] = $orders;
    
        return $this;
    }

    /**
     * Remove orders
     *
     * @param \JS\DefaultBundle\Entity\Order $orders
     */
    public function removeOrder(\JS\DefaultBundle\Entity\Order $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }
}