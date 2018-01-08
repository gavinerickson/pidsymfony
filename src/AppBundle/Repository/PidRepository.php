<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 23/11/2017
 * Time: 05:35
 */

namespace AppBundle\Repository;



use Doctrine\ORM\EntityRepository;


class PidRepository extends EntityRepository
{


	public function findMyPids($userId)
	{

		return $this->createQueryBuilder('Pid')
			->andWhere('Pid.owner = '.$userId)
			->leftJoin('Pid.alsoInvolved','me')
			->orWhere('me.id ='.$userId)
			->getQuery()
			->execute();

	}


	public function findPidsForReminder($userId)
	{
		$pids =  $this->createQueryBuilder('Pid')
			->Where('Pid.RAG != :complete')
			->setParameter('complete', 'DARKGRAY')
			->andWhere('Pid.owner = :user')
			->setParameter('user', $userId)
			->leftJoin('Pid.alsoInvolved','me')
			->orWhere('me.id ='.$userId)

			->getQuery()
			->execute();

		$filtered =[];

		foreach ($pids as $pid)
		{
			$pid->pidstart = $pid->getPidstart()->format('Y-m-d H:i:s');

			$now = new \DateTime();

			if($pid->pidstart <= strtotime($now->format("Y-m-d")." 00:00:00"))
			{
				//other users PIDs fall through where clause of main query
				if ($pid->getRag() != 'DARKGRAY')
				{
					$filtered[] = $pid;
				}

			}
		}

		return $filtered;



	}


}


