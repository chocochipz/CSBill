<?php

namespace CS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CS\UserBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="CS\UserBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class User implements UserInterface, EquatableInterface
{
    /**
     * @var integer $id
     * 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $username
     * 
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     * @Assert\MinLength(limit=3)
     */
    protected $username;

    /**
     * @var string $salt
     * 
     * @ORM\Column(type="string", length=32)
     */
    protected $salt;

    /**
     * @var string $password
     * 
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank()
     */
    protected $password;

    /**
     * @var string $email
     * 
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @var boolean $active
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active;

    /**
     * @var string $created
     * 
     * @ORM\Column(name="created", type="datetime")
     * @Gedmo\Timestampable(on="create")
     * @Assert\DateTime()
     */
    private $created;

    /**
     * @var string $updated
     * 
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @Assert\DateTime()
     */
    private $updated;

    /**
     * @var string $deleted
     * 
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $deleted;

    /**
     * @var ArrayCollection $roles
     * 
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users", cascade="ALL")
     * @Orm\OrderBy({"name" = "ASC"})
     * @Assert\Valid()
     */
    protected $roles;
    
    /**
     * Constructer
     */
    public function __construct()
    {
        $this->active = true;
        $this->setSalt(md5(uniqid(null, true)));
        $this->roles = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
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
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
		$this->salt = $salt;
		return $this;
	}
	
    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
    	return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
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

    /**
     * Set email
     *
     * @param string $email
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
     * Set active
     *
     * @param boolean|integer $active
     * @return User
     */
    public function setActive($active)
    {
    	return $this->active = (boolean) $active;
    }
    
    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
    	return $this->isActive();
    }

    /**
     * is active
     *
     * @return boolean 
     */
    public function isActive()
    {
    	return $this->active ? true : false;
    }
    
    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Client
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return new DateTime($this->created);
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Client
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return new DateTime($this->updated);
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return Client
     */
    public function setDeleted(\DateTime $deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getDeleted()
    {
        return new DateTime($this->created);
    }

    public function eraseCredentials()
    {

    }

    public function isEqualTo(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }
    
    /**
     * Add role
     * 
     * @param Role $role
     * @return User
     */
    public function addRole(Role $role)
    {
    	$this->roles[] = $role;
    	$role->addUser($this);
    	
    	return $this;
    }

	/**
	 * Get roles
	 * 
	 * @return ArrayCollection
	 */
    public function getRoles()
    {
    	return $this->roles;
    }    
}
