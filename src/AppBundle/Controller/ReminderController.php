<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 08/01/2018
 * Time: 17:04
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ReminderController extends Controller
{
	/**
	 * @Route("/reminder", name="reminder_email_trigger")
	 */
	public function reminderAction()
	{
		//get users

		$users = $this->getDoctrine()->getManager()
			->getRepository('AppBundle\Entity\User')
			->findAll();


		//for each user get pids where start date is less than todays date and item is not marked complete

		foreach ($users as $user)
		{
			$pids = $this->getDoctrine()->getManager()
				->getRepository('AppBundle\Entity\Pid')
				->findPidsForReminder($user->getId());

			if($pids)
			{
				$this->sendEmail($user, $pids);
			}



		}

		$this->addFlash('success','done');
		return $this->render(':default:index.html.twig');




	}


	public function sendEmail($user, $pids)
	{
		$message = (new \Swift_Message('PID reminder'))
			->setFrom('info@acupuncture.org.uk')
			->setTo($user->getEmail())
			->setBody(
				$this->renderView(
				// app/Resources/views/Emails/registration.html.twig
					'reminder/reminder.html.twig',
					array(
						'user' => $user,
						'pids' => $pids
					)
				),
				'text/html'
			)

		;

		$mailer = $this->container->get('swiftmailer.mailer.default');
		$mailer->send($message);

		// or, you can also fetch the mailer service this way
		// $this->get('mailer')->send($message);





	}
}