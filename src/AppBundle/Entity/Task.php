<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaskRepository")
 * @ORM\Table(name="task")
 */
class Task
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pid", inversedBy="tasks")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $parentpid;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
	private $title;

	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $description;

	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="date")
	 */
	private $startdate;

	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="date")
	 */
	private $enddate;

	/**
	 * @ORM\Column(type="string")
	 */
	private $RAG;


	public function __toString()
	{
		return (string) $this->getTitle();
	}



	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getParentpid()
	{
		return $this->parentpid;
	}

	/**
	 * @param mixed $parentpid
	 */
	public function setParentpid($parentpid)
	{
		$this->parentpid = $parentpid;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getStartdate()
	{
		return $this->startdate;
	}

	/**
	 * @param mixed $startdate
	 */
	public function setStartdate($startdate)
	{
		$this->startdate =  $startdate;
	}

	/**
	 * @return mixed
	 */
	public function getEnddate()
	{
		return $this->enddate;
	}

	/**
	 * @param mixed $enddate
	 */
	public function setEnddate($enddate)
	{
		$this->enddate = $enddate;
	}

	/**
	 * @return mixed
	 */
	public function getRAG()
	{
		return $this->RAG;
	}

	/**
	 * @param mixed $RAG
	 */
	public function setRAG($RAG)
	{
		$this->RAG = $RAG;
	}



}