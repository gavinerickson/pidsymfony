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




}


