<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 23/11/2017
 * Time: 05:11
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields={"username","email"}, message="It looks like you already have an account!")
 */
class User implements UserInterface
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="string")
	 */
	private $username;

	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 * @ORM\Column(type="string")
	 */
	private $email;

	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="json_array")
	 */
	private $roles = [];

	/**
	 * A user has one line manager.
	 * @ORM\OneToOne(targetEntity="User")
	 */
	private $linemanager;

	/**
	 *
	 * @ORM\Column(type="string")
	 */
	private $password;

	/**
	 * A non-persisted field that's used to create the encoded password.
	 * @Assert\NotBlank(groups={"Registration"})
	 *
	 * @var string
	 */
	private $plainPassword;

	/**
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Pid", mappedBy="alsoInvolved")
	 *
	 */
	private $pidworkers;


	public function __construct()
	{
		$this->roles = new ArrayCollection();
		$this->pidworkers = new ArrayCollection();
	}

	public function __toString()
	{
		return (string) $this->getName();
	}

	public function getSalt()
	{
		// TODO: Implement getSalt() method.
	}

	public function eraseCredentials()
	{
		$this->plainPassword = null;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}



	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @return array
	 */
	public function getRoles()
	{
		$roles = $this->roles;

		if(empty($roles[0]))
		{
			$roles[] = 'ROLE_USER';
			return array($roles);
		}


		return $roles;
	}

	/**
	 * @param array
	 */
	public function setRoles(array $roles)
	{
		$this->roles = $roles;
	}

	/**
	 * @return mixed
	 */
	public function getLinemanager()
	{
		return $this->linemanager;
	}

	/**
	 * @param mixed $linemanager
	 */
	public function setLinemanager($linemanager)
	{

		$this->linemanager = $linemanager;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getPlainPassword()
	{
		return $this->plainPassword;
	}

	/**
	 * @param string $plainPassword
	 */
	public function setPlainPassword($plainPassword)
	{
		$this->plainPassword = $plainPassword;
		// forces the object to look "dirty" to Doctrine. Avoids
		// Doctrine *not* saving this entity, if only plainPassword changes
		$this->password = null;
	}

	/**
	 * @return mixed
	 */
	public function getPidworkers()
	{
		return $this->pidworkers;
	}






}