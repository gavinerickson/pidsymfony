<?php

namespace AppBundle\Form;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PIDForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title')
			->add('description', TextareaType::class)
			->add('deadline', DateType::class,[
				'widget' => 'single_text',
				'html5' => true,

			])
			->add('owner', EntityType::class,[
				'class' => User::class,
				'multiple' => false,
				'choice_label' =>'name',
				'label' => 'Owner'
			])
			->add('alsoInvolved',EntityType::class,[
				'class' => User::class,
				'multiple' => true,
				'choice_label' => 'name',
				'label' => 'Others involved'
			])

			->add('RAG', ChoiceType::class,[
				'choices' => [
					'RED' => 'RED',
					'AMBER' => 'DARKORANGE',
					'GREEN' => 'GREEN',
					'COMPLETE' => 'DARKGRAY'
				],
				'label'=> 'Status'
			])
			->add('approval',ChoiceType::class,[
				'choices' => [
					'yes' => 'yes',
					'no' => 'no',
					'pending' => 'pending'
				]
			])
			->add('pidnote',TextareaType::class,[
				'label' => 'General notes'
			])
			->add('budgetrequested',NumberType::class,[
				'label' => 'Total budget approved',
				'empty_data' => 0,
				'attr' => [
					'placeholder' => 0
				]
			])
			->add('budgetallocated',NumberType::class,[
				'label' => 'Budget allocated',
				'empty_data' => 0,
				'attr' => [
					'placeholder' => 0
				]
			])
			->add('budgetspent',NumberType::class,[
				'label' => 'Budget spent',
				'empty_data' => 0,
				'attr' => [
					'placeholder' => 0
				]
			])

			->add('remainingamount',NumberType::class,[
				'label' => 'Remaining amount',
				'empty_data' => 0,

			])
			->add('assets',TextareaType::class,[
				'label' => 'Assets'
			])

			->add('financialnote', TextareaType::class,[
				'label' => 'Financial notes'
				])

			->add('tasks', CollectionType::class,[
				'entry_type' => TaskEmbeddedForm::class,
				'allow_delete' => true,
				'allow_add' => true,
				'by_reference' => false,
			]);

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => 'AppBundle\Entity\Pid'
		]);
	}

	public function getBlockPrefix()
	{
		return 'app_bundle_pidform';
	}
}
