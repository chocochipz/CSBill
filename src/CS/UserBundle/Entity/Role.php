<?php

namespace CS\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="roles")
 * @ORM\Entity()
 * @UniqueEntity("name")
 * @UniqueEntity("role")
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class Role implements RoleInterface
{
	/**
	 * @var integer $id
	 * 
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id()
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
     * @var string $name
     * 
     * @ORM\Column(name="name", type="string", length=25, unique=true)
     * @Assert\NotBlank()
     * @Assert\MinLength(limit=3)
     */
	protected $name;
	
	/**
     * @var string $role
     * 
     * @ORM\Column(name="role", type="string", length=25, unique=true)
     * @Assert\NotBlank()
     * @Assert\MinLength(limit=3)
	 */
	protected $role;
	
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
	 * @var ArrayCollection $users
	 * 
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="groups", cascade="ALL")
	 */
	protected $users;
	
	/**
	 * constructer
	 */
	public function __construct()
	{
		$this->users = new ArrayCollection();
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
	 * @return Role
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
	 * Set role
	 * 
	 * @param string $role
	 * @return Role
	 */
	public function setRole($role)
	{
		$this->role = $role;
		return $this;
	}
	
	/**
	 * Get role
	 * 
	 * @return string
	 */
	public function getRole()
	{
		return $this->role;
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
	
	/**
	 * Add user
	 * 
	 * @param User $user
	 * 
	 * @return Role
	 */
	public function addUser(User $user)
	{
		$this->users[] = $user;
		
		return $this;
	}
	
	/**
	 * Get users
	 * 
	 * @return ArrayCollection
	 */
	public function getUsers()
	{
		return $this->users;
	}
	
	/**
	 * Display class string, showing the role name
	 * 
	 * @return string
	 */
	public function __toString()
	{
		return $this->getName();
	}
}
