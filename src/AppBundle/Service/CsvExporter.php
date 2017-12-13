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
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\StreamedResponse;


class CsvExporter
{



	public function getResponseFromQueryBuilder(QueryBuilder $queryBuilder, $columns, $filename)
	{
		$entities = new ArrayCollection($queryBuilder->getQuery()->getResult());
		$response = new StreamedResponse();
		if (is_string($columns)) {
			$columns = $this->getColumnsForEntity($columns);
		}
		$response->setCallback(function () use ($entities, $columns) {
			$handle = fopen('php://output', 'w+');
			// Add header
			fputcsv($handle, array_keys($columns));
			while ($entity = $entities->current()) {
				$values = [];
				foreach ($columns as $column => $callback) {
					$value = $callback;
					if (is_callable($callback)) {
						$value = $callback($entity);
					}
					$values[] = $value;
				}
				fputcsv($handle, $values);
				$entities->next();
			}
			fclose($handle);
		});
		$response->headers->set('Content-Type', 'text/csv; charset=utf-8');
		$response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
		return $response;
	}


		private function getColumnsForEntity($class)
		{
			$columns[Pid::class] = [
				'Pid Id' => function (Pid $pid) {
				    return $pid->getId();
				},
				'Title' => function (Pid $pid) {
					return $pid->getTitle();
				},
				'Description' => function (Pid $pid) {
					return $pid->getDescription();
				},
				'Owner' => function (Pid $pid) {
					return $pid->getOwner();
				},
				'Approval' => function (Pid $pid)
				{
					return $pid->getApproval();
				}




			];

			if (array_key_exists($class, $columns)) {
				return $columns[$class];
			}
			throw new \InvalidArgumentException(sprintf(
				'No columns set for "%s" entity',
				$class
			));
		}

}