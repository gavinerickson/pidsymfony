<?php

require '/var/www/pidsymfony/vendor/GanttChartPHP/autoloader.php';

use GanttChart\GanttChart;

$rootDir = '/var/www/pidsymfony';

$array_legend_data = include '/var/www/pidsymfony/vendor/GanttChartPHP/tests/array_legend_data.php';

$gantt_graph = new GanttChart('en_GB');

try{
	$gantt_graph->setData($data)

		->render(true);
}
catch (Exception $exception){

}

