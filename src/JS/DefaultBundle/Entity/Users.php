<?php


namespace JS\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * User
 *
 * @ORM\Table(name="js_users")
 * @ORM\Entity()
 */
class Users {
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
    protected $login;

    /**
     * @ORM\Column(length=255)
     */
    protected $password;

    /**
     * @ORM\Column(length=255)
     */
    protected $solt;


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
     * Set login
     *
     * @param string $login
     * @return Users
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set solt
     *
     * @param string $solt
     * @return Users
     */
    public function setSolt($solt)
    {
        $this->solt = $solt;
    
        return $this;
    }

    /**
     * Get solt
     *
     * @return string 
     */
    public function getSolt()
    {
        return $this->solt;
    }
}