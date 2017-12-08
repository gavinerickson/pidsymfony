<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 30/11/2017
 * Time: 15:05
 */

namespace AppBundle\Twig;


class StrpadExtension extends \Twig_Extension
{
	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('strpad', array($this, 'strpad')),
		);
	}

	public function strpad($number, $pad_length, $pad_string) {
		return str_pad($number, $pad_length, $pad_string, STR_PAD_LEFT);
	}
}