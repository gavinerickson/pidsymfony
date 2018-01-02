<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 12/12/2017
 * Time: 16:41
 */

namespace AppBundle\Controller\EasyAdmin;

use AppBundle\Entity\Pid;
use AppBundle\Service\AdminCsvExporter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{



	private $adminCsvExporter;

	public function __construct(AdminCsvExporter $adminCsvExporter)
	{
		$this->adminCsvExporter = $adminCsvExporter;
	}


	public function exportAction()
	{



		return $this->adminCsvExporter->exportCsv('pids.csv');
	}






}