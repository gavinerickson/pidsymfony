<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 01/12/2017
 * Time: 17:09
 */

namespace AppBundle\Controller;






use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class GanttController extends Controller
{
	/**
	 * @Route("/gantt", name="gantt_user_pids")
	 */
	public function ganttAction()
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



		//dump($pids);

		//$array_data = include $rootDir.'/../vendor/GanttChartPHP/tests/array_data.php';

		$array_data = $this->getArrayData($pids);



		return $this->render('pid/gantt.html.php', array(
			'data' => $array_data
		));
	}


	/**
	 * @Route("/ganttmaster", name="gantt_master_pids")
	 */
	public function ganttmasterAction()
	{

		/*
		 * at a later date update data selction based on user and line management properties
		 *
		$user = $this->get('security.token_storage')
			->getToken()
			->getUser();

*/

		$pids = $this->getDoctrine()->getManager()
			->getRepository('AppBundle\Entity\Pid')
			->findAll();

		if (!$pids)
		{
			throw $this->createNotFoundException(
				'No PIDs found'
			);
		}



		//dump($pids);

		//$array_data = include $rootDir.'/../vendor/GanttChartPHP/tests/array_data.php';

		$array_data = $this->getArrayData($pids);



		return $this->render('pid/gantt.html.php', array(
			'data' => $array_data
		));
	}



	public function getArrayData($pids)
	{

		$mypids = [];

		foreach ($pids as $pid)
		{


			$task_array =
				array(
					'label'       => $pid->getTitle(),
					'start'       => $pid->getPidstart()->format('Y-m-d'),
					'end'         => $pid->getPidend()->format('Y-m-d'),
					'description' => $pid->getDescription(),
					'color'       => 'red',
				);

			$something = array (
				'label' => $pid->getId(),
				'series' => array (
					array (
						'label' => $pid->getTitle(),
						'allocations' => array (
							$task_array
						),
					),
				),
			);

			$mypids[] = $something;

			foreach ($pid->getTasks() as $task)
			{

				switch ($task->getRAG())
				{
					case ("RED"):
						$color = 'red';
						break;

					case ("AMBER"):
						$color = 'orange';
						break;

					case ("GREEN"):
						$color = 'green';
						break;

					default:
				}


				$task_array =
					array(
						'label'       => $task->getTitle(),
						'start'       => $task->getStartdate()->format('Y-m-d'),
						'end'         => $task->getEnddate()->format('Y-m-d'),
						'description' => $task->getDescription(),
						'color'       => $color,
					);

			$something = array (
								'label' => '',
								'series' => array (
									array (
										'label' => $task->getTitle(),
										'allocations' => array (
											$task_array
										),
									),
								),
							);

			$mypids[] = $something;


			}



		}

		return $mypids;

	}
}