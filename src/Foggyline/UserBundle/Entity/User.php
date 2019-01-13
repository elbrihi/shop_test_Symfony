<?php

namespace Foggyline\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Foggyline\UserBundle\Repository\UserRepository")
 */
class User Implements UserInterface, \Serializable
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
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * 
     * @ORM\OneToMany(targetEntity="Foggyline\CatalogBundle\Entity\Category", mappedBy="user")
     */
    private $categories ;


    private $plainPassword;

    /**
     * 
     * @ORM\Column(name="roles", type="json_array", nullable= true)
     */
    private $roles = array();
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
     * Constructor
     */
    public function __construct()
    {
        
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
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
    public function setplainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }
    public function getplainPassword()
    {
        return $this->plainPassword;
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
 

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
        ));
    }
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
    public function getRoles()
    {
        $tempRoles = $this->roles ;
        if(in_array('ROLE_USER',$tempRoles)===false)
        {
            $tempRoles[] = 'USER_ROLE';
        }
        return $tempRoles;
    }
    public function eraseCredentials()
    {
    }
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }
   
  

    /**
     * Add category
     *
     * @param \Foggyline\CatalogBundle\Entity\Category $category
     *
     * @return User
     */
    public function addCategory(\Foggyline\CatalogBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Foggyline\CatalogBundle\Entity\Category $category
     */
    public function removeCategory(\Foggyline\CatalogBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
   
}
