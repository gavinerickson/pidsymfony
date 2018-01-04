<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 03/01/2018
 * Time: 21:36
 */

namespace AppBundle\Twig;


use AppBundle\Entity\User;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EasyAdminExtension extends \Twig_Extension
{
	private $authorizationChecker;

	public function __construct(AuthorizationCheckerInterface $authorizationChecker)
	{
		$this->authorizationChecker = $authorizationChecker;
	}

	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter(
				'filter_admin_actions',
				[$this, 'filterActions']
			)
		];
	}

	public function filterActions(array $itemActions, $item)
	{

		if ($item instanceof User && !$this->authorizationChecker->isGranted('ROLE_SUPERADMIN')) {
			unset($itemActions['edit']);
			unset($itemActions['delete']);
		}
		// export action is rendered by us manually
		unset($itemActions['export']);

		return $itemActions;
	}

}