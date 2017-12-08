<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 29/11/2017
 * Time: 18:26
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('_username')
			->add('_password', PasswordType::class)
		;
	}
}