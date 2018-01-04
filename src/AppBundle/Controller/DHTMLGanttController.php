<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 18/12/2017
 * Time: 18:09
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DHTMLGanttController extends Controller
{

	/**
	 * renders page
	 * @Route("/dhtmlgantt", name="display_gantt_data")
	 */
	public function dhtmlGanttAction()
	{
		return $this->render('gantt/gantt.html.twig');
	}

	/**
	 * renders page
	 * @Route("/masterdhtmlgantt", name="display_mastergantt_data")
	 */
	public function dhtmlMasterGanttAction()
	{
		return $this->render('gantt/mastergantt.html.twig');
	}


	/**
	 * @Route("/getgantt", name="get_gantt_data")
	 */
	public function getGanttDataAction()
	{

		$user = $this->get('security.token_storage')
			->getToken()
			->getUser();


		$pids = $this->getDoctrine()->getManager()
			->getRepository('AppBundle\Entity\Pid')
			->findMyPids($user->getId());

		if (!$pids)
		{
			throw $this->createNotFoundException(
				'No PIDs found'
			);
		}

		$mypids=$this->getArrayData($pids);

		$mypids =  json_encode($mypids, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

		$response = new Response($mypids);
		$response->headers->set('Content-Type', 'application/json');

		return $response;


	}

	/**
	 * @Route("/getmastergantt", name="get_mastergantt_data")
	 */
	public function getMasterGanttDataAction()
	{



		$pids = $this->getDoctrine()->getManager()
			->getRepository('AppBundle\Entity\Pid')
			->findAll();


		if (!$pids)
		{
			throw $this->createNotFoundException(
				'No PIDs found'
			);
		}

		$mypids=$this->getArrayData($pids);

		$mypids =  json_encode($mypids, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

		$response = new Response($mypids);
		$response->headers->set('Content-Type', 'application/json');

		return $response;


	}


	public function getArrayData($pids)
	{

		$mypids = [];
		$mylinks =[];

		$pidId=1;





		foreach ($pids as $pid)
		{
			//top level pid
			$pidarray = array (
				'id' => $pidId,
				'text' => str_pad($pid->getId(), 5, '0', STR_PAD_LEFT).' '.$pid->getTitle(),
				'start_date' => $pid->getPidstart()->format('Y-m-d H:i:s'),
				'duration' => $pid->getDuration(),
				'order' =>10,
				'color' => $pid->getRAG(),

				'open' => false
			);

			$mypids[] = $pidarray;

			$taskId = $pidId+1;

			$deadline = array (
				'id' => $taskId,
				'text' => 'deadline for '.$pid->getTitle(),
				'start_date' => $pid->getDeadline()->format('Y-m-d H:i:s'),
				'type' => 'gantt.config.types.milestone',
				'parent' => $pidId,

				'open' => false
			);

			$linkarray = array (
				'id' => $taskId,
				'source' => $pidId,
				'target' => $taskId,
				'type' => '1'

			);

			$mypids[] = $deadline;
			$mylinks[] = $linkarray;

			$taskId++;
			foreach ($pid->getTasks() as $task)
			{
				$pidarray = array (
					'id' => $taskId,
					'text' => $task->getTitle(),
					'start_date' => $task->getStartdate()->format('Y-m-d H:i:s'),
					'duration' => $task->getDuration(),
					'parent' => $pidId,
					'order' =>10,
					'color' => $task->getRAG(),

					'open' => false
				);

				$linkarray = array (
					'id' => $taskId,
					'source' => $pidId,
					'target' => $taskId,
					'type' => '1'

				);

				$mypids[] = $pidarray;
				$mylinks[] = $linkarray;
				$taskId++;

			}
			$pidId = $taskId + 1;


		}

		$data = array('data' => $mypids,
			'links' => $mylinks
		);

		return $data;


	}




}