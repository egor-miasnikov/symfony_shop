<?php

namespace JS\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;


/**
 * Carusel
 *
 * @ORM\Table(name="js_carusel")
 * @ORM\Entity(repositoryClass="JS\DefaultBundle\Repository\CaruselRepository")
 */

class Carusel
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
     * @ORM\Column(length=255)
     */
    protected $url;

    /**
     * @ORM\Column(length=255)
     */
    protected $image;


    protected $file;

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
     * @return Carusel
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
     * Set url
     *
     * @param string $url
     * @return Carusel
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * Set image
     *
     * @param string $image
     * @return Carusel
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

     /**
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
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
}