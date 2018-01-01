<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 12/12/2017
 * Time: 17:48
 */

namespace AppBundle\Service;


use AppBundle\Entity\Pid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class AdminCsvExporter
{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}




	public function getPIds()
	{

		$pids = $this->em
			->getRepository('AppBundle\Entity\Pid')
			->findAll();

		return $pids;

	}



	public function exportCsv($filename)
	{

		$serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

		$response = new Response();

		$rows = [];

		$pids = $this->getPIds();

		foreach ($pids as $pid)
		{
			$row = array (

				'title' => str_pad($pid->getId(), 5, '0', STR_PAD_LEFT).' '.$pid->getTitle(),
				'start_date' => $pid->getPidstart()->format('Y-m-d'),
				'end_date' => $pid->getPidend()->format('Y-m-d'),
				'deadline' => $pid->getDeadline()->format('Y-m-d'),
				'description' => $pid->getDescription(),
				'rag' => $pid->getRAG(),
				'owner' => $pid->getOwner()->getName(),
				'approval' => $pid->getApproval(),
				'budgetrequested' => $pid->getBudgetrequested(),
				'budgetspent' => $pid->getBudgetspent(),
				'budgetallocated'=>$pid->getBudgetallocated(),
				'remainingamount'=>$pid->getRemainingamount(),
				'financialnote' => $pid->getFinancialnote(),
				'assets' => $pid->getAssets(),
				'pidnote' => $pid->getPidnote()

			);

			$rows[] = $row;

			$tasks = $pid->getTasks();

			foreach ($tasks as $task)
			{
				$row = array (

					'title' => '| '.$task->getTitle(),
					'start_date' => $task->getStartdate()->format('Y-m-d'),
					'end_date' => $task->getEnddate()->format('Y-m-d'),
					'deadline' => '',
					'description' => $task->getDescription(),
					'rag' => $task->getRAG(),
					'owner' =>'',
					'approval' => '',
					'budgetrequested'=> '',
					'budgetspent' => '',
					'budgetallocated' => '',
					'remainingamount' => '',
					'financialnote' => '',
					'assets' => '',
					'pidnote' => ''

				);
				$rows[] = $row;
			}
			$rows[] = [];

		}


		$data = $serializer->encode($rows, 'csv');


		$response->headers->set('Content-Type', 'text/csv; charset=utf-8');
		$response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

		$response->setContent($data);
		return $response;

	}

}