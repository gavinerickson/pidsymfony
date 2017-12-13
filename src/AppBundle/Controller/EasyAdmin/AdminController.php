<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 12/12/2017
 * Time: 16:41
 */

namespace AppBundle\Controller\EasyAdmin;

use AppBundle\Entity\Pid;
use AppBundle\Service\CsvExporter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{


	private $csvExporter;


	public function __construct(CsvExporter $csvExporter)
	{
		$this->csvExporter = $csvExporter;
	}


	public function exportAction()
	{

		$sortDirection = $this->request->query->get('sortDirection');
		if (empty($sortDirection) || !in_array(strtoupper($sortDirection), ['ASC', 'DESC'])) {
			$sortDirection = 'DESC';
		}
		$queryBuilder = $this->createListQueryBuilder(
			$this->entity['class'],
			$sortDirection,
			$this->request->query->get('sortField'),
			$this->entity['list']['dql_filter']
		);
		return $this->csvExporter->getResponseFromQueryBuilder(
			$queryBuilder,
			Pid::class,
			'pids.csv'
		);
	}






}