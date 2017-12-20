<?php

namespace AppBundle\Form;

use AppBundle\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskEmbeddedForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title')
			->add('description', TextareaType::class)
			->add('RAG', ChoiceType::class,[
				'choices' => [
					'RED' => 'RED',
					'AMBER' => 'DARKORANGE',
					'GREEN' => 'GREEN',
					'COMPLETE' => 'DARKGRAY'
				],
				'label'=> 'Status'
			])
			->add('startdate', DateType::class,[
				'widget' => 'single_text',
				'html5' => true,
			])
			->add('enddate', DateType::class,[
				'widget' => 'single_text',
				'html5' => true,

			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Task::class
		]);
	}

	public function getBlockPrefix()
	{
		return 'app_bundle_task_embedded_form';
	}
}
