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
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PidRepository")
 * @ORM\Table(name="pid")
 */
class Pid
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank()
	 */
	private $title;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $description;

	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="date")
	 */
	private $deadline;


	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
	 */
	private $owner;

	/**
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="pidworkers")
	 * @ORM\JoinTable(name="pid_users")
	 */
	private $alsoInvolved = [];

	/**
	 * @ORM\Column(type="string")
	 */
	private $RAG;


	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $approval;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $pidnote;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	private $budgetrequested;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	private $budgetspent;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	private $budgetallocated;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	private $remainingamount;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $assets;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $financialnote;


	/**
	 * @ORM\OneToMany(
	 *     targetEntity="AppBundle\Entity\Task",
	 *     mappedBy="parentpid",
	 *     orphanRemoval=true,
	 *     cascade={"persist"},
	 *     fetch="EXTRA_LAZY")
	 * @Assert\Valid()
	 *
	 */
	private $tasks;


	public function __construct()
	{
		$this->alsoInvolved = new ArrayCollection();
		$this->tasks        = new ArrayCollection();
	}

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
	public function getDeadline()
	{
		return $this->deadline;
	}

	/**
	 * @param mixed $deadline
	 */
	public function setDeadline($deadline)
	{
		$this->deadline = $deadline;
	}




	/**
	 * @return user object
	 */
	public function getOwner()
	{

		return $this->owner;
	}


	public function setOwner(User $owner)
	{
		$this->owner = $owner;
	}

	/**
	 * @return ArrayCollection|User[]
	 */
	public function getAlsoInvolved()
	{
		return $this->alsoInvolved;
	}

	/**
	 * @param mixed $alsoInvolved
	 */
	public function setAlsoInvolved($alsoInvolved)
	{
		$this->alsoInvolved = $alsoInvolved;
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

	/**
	 * @return mixed
	 */
	public function getApproval()
	{
		return $this->approval;
	}

	/**
	 * @param mixed $approval
	 */
	public function setApproval($approval)
	{
		$this->approval = $approval;
	}

	/**
	 * @return mixed
	 */
	public function getPidnote()
	{
		return $this->pidnote;
	}

	/**
	 * @param mixed $pidnote
	 */
	public function setPidnote($pidnote)
	{
		$this->pidnote = $pidnote;
	}



	/**
	 * @return mixed
	 */
	public function getBudgetrequested()
	{
		return $this->budgetrequested;
	}

	/**
	 * @param mixed $budgetrequested
	 */
	public function setBudgetrequested($budgetrequested)
	{
		$this->budgetrequested = $budgetrequested;
	}

	/**
	 * @return mixed
	 */
	public function getBudgetspent()
	{
		return $this->budgetspent;
	}

	/**
	 * @param mixed $budgetspent
	 */
	public function setBudgetspent($budgetspent)
	{
		$this->budgetspent = $budgetspent;
	}

	/**
	 * @return mixed
	 */
	public function getBudgetallocated()
	{
		return $this->budgetallocated;
	}

	/**
	 * @param mixed $budgetallocated
	 */
	public function setBudgetallocated($budgetallocated)
	{
		$this->budgetallocated = $budgetallocated;
	}

	/**
	 * @return mixed
	 */
	public function getRemainingamount()
	{
		return $this->remainingamount;
	}

	/**
	 * @param mixed $remainingamount
	 */
	public function setRemainingamount($remainingamount)
	{
		$this->remainingamount = $remainingamount;
	}

	/**
	 * @return mixed
	 */
	public function getAssets()
	{
		return $this->assets;
	}

	/**
	 * @param mixed $assets
	 */
	public function setAssets($assets)
	{
		$this->assets = $assets;
	}

	/**
	 * @return mixed
	 */
	public function getFinancialnote()
	{
		return $this->financialnote;
	}

	/**
	 * @param mixed $financialnote
	 */
	public function setFinancialnote($financialnote)
	{
		$this->financialnote = $financialnote;
	}




	/**
	 * @return Assert\Date
	 */
	public function getPidstart()
	{
		$tasks = $this->getTasks()->toArray();

		//$mine = array_column($tasks->collection->toArray(), 'startdate');

		$startDates=[];

		foreach ($tasks as $task)
		{
			$taskstart = $task->getStartdate();
			$startDates[] = $taskstart;

		}

		if(!empty($startDates)){
			asort($startDates);
			reset($startDates);
			//dump($startDates);
			return reset($startDates);
		}



	}


	/**
	 * @return Assert\Date
	 */
	public function getPidend()
	{
		$tasks = $this->getTasks()->toArray();

		//$mine = array_column($tasks->collection->toArray(), 'startdate');

		$endDates=[];

		foreach ($tasks as $task)
		{
			$taskend = $task->getEnddate();
			$endDates[] = $taskend;

		}

		if(!empty($endDates)){
			arsort($endDates);
			//dump($endDates);
			return reset($endDates);

		}



	}


	/**
	 * @return ArrayCollection|task[]
	 */
	public function getTasks()
	{
		return $this->tasks;
	}

	public function addTask(Task $task){

		if($this->tasks->contains($task))
		{
			return;
		}

		$this->tasks[] = $task;
		// needed to update the owning side of the relationship!
		$task->setParentpid($this);

	}


	public function removeTask(Task $task)
	{
		if(!$this->getTasks()->contains($task))
		{
			return;
		}

		$this->tasks->removeElement($task);
		// needed to update the owning side of the relationship!
		$task->setParentpid(null);


	}


	public function getDuration()
	{


		$interval   =   $this->getPidstart()->diff($this->getPidend());

		return $interval->format("%a");

	}






}