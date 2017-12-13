<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 11/12/2017
 * Time: 18:01
 */

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class PDFfromHTMLService
{

	private $container;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}


	public function returnPDFResponseFromHTML($html){
		//set_time_limit(30); uncomment this line according to your needs
		// If you are not in a controller, retrieve of some way the service container and then retrieve it
		$pdf = $this->container->get("white_october.tcpdf")->create('horizontal', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//if you are in a controlller use :
		//$pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetAuthor('Our Code World');
		$pdf->SetTitle(('Our Code World Title'));
		$pdf->SetSubject('Our Code World Subject');
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('helvetica', '', 11, '', true);
		//$pdf->SetMargins(20,20,40, true);
		$pdf->AddPage();

		$filename = 'ourcodeworld_pdf_demo';

		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		$pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
	}


}