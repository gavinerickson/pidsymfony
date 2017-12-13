<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 11/12/2017
 * Time: 17:27
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\PDFfromHTMLService;


ini_set('max_execution_time', 300);

class GanttPDFController extends Controller
{


	private $PDFfromHTMLService;

	/**
	 * GanttPDFController constructor.
	 *
	 * @param $PDFfromHTMLService
	 */
	public function __construct(PDFfromHTMLService $PDFfromHTMLService)
	{
		$this->PDFfromHTMLService = $PDFfromHTMLService;
	}


	/**
	 * @Route("/ganttpdf", name="gantt_pdf")
	 */
	public function ganttpdfAction()
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





		//$array_data = include $rootDir.'/../vendor/GanttChartPHP/tests/array_data.php';

		$array_data = $this->getArrayData($pids);



		$html= $this->render('pid/gantt.html.php', array(
			'data' => $array_data
		));


		$this->PDFfromHTMLService->returnPDFResponseFromHTML($html);

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