<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 23/11/2017
 * Time: 05:08
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Pid;
use AppBundle\Entity\Task;
use AppBundle\Form\PIDForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class PidController extends Controller
{
	/**
	 * @Route("/pids", name="list_user_pids")
	 */
	public function listAction(Request $request)
	{
		$user = $this->get('security.token_storage')
			->getToken()
			->getUser();


		$pids = $this->getDoctrine()->getManager()
						->getRepository('AppBundle\Entity\Pid')
						->findMyPids($user->getId());

		$this->addFlash(
			'success',
			sprintf('Logged in as: %s', $this->getUser()->getName())
		);


		if (!$pids) {
		/*	throw $this->createNotFoundException(
				'No PIDs found'
			);
		*/
		}


		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$pids,
			$request->query->getInt('page', 1)/*page number*/,
			10/*limit per page*/
		);

		return $this->render('pid/list.html.twig', [
			'pids' => $pagination
		]);
	}

	/**
	 * @Route("/newpid", name="new_user_pid")
	 */
	public function newAction(Request $request)
	{
		$user = $this->get('security.token_storage')
			->getToken()
			->getUser();


		$pid = new Pid();

		$task = new Task();

		$pid->addTask($task);

		$form = $this->createForm(PIDForm::class, $pid);



		// only handles data on POST
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$pid = $form->getData();

			$em = $this->getDoctrine()->getManager();
			$em->persist($pid);
			$em->flush();



			return $this->redirectToRoute('list_user_pids');
		}

		return $this->render('pid/new.html.twig', [
			'PIDForm' => $form->createView(),
			'pid' => $pid,
			'user'=>$user,


		]);


	}


	/**
	 * @Route("/pid/{id}", name="edit_user_pid")
	 */
	public function editAction(Request $request, Pid $pid)
	{
		//check if my pid??

		$form = $this->createForm(PIDForm::class, $pid);

		// only handles data on POST
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$pid = $form->getData();

			$em = $this->getDoctrine()->getManager();
			$em->persist($pid);
			$em->flush();



			return $this->redirectToRoute('list_user_pids');
		}



		return $this->render('pid/edit.html.twig', [
			'PIDForm' => $form->createView(),

			//just for dumping
			'pid' => $pid,



		]);


	}







}