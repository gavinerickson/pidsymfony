<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 14/01/2018
 * Time: 21:05
 */

namespace AppBundle\Command;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;

class ReminderEmailCommand extends Command
{
	use LockableTrait;

	private $em;
	private $twig;
	private $mailer;

	public function __construct(EntityManagerInterface $em, Environment $twig, \Swift_Mailer $mailer)
	{
		$this->em = $em;
		$this->twig = $twig;
		$this->mailer = $mailer;
		parent::__construct();
	}


	protected function configure()
	{
		$this
			// the name of the command (the part after "bin/console")
			->setName('send:reminder-email')

			// the short description shown while running "php bin/console list"
			->setDescription('sends a reminder email')

			// the full command description shown when running the command with
			// the "--help" option
			->setHelp('This command will get a list of active PIDs and send a relevant list to each user')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		//use the lock trait to prohibit multiple runs
		if (!$this->lock()) {
			$output->writeln('The command is already running in another process.');

			return 0;
		}

		$users = $this->em->getRepository('AppBundle\Entity\User')
			->findAll();


		//for each user get pids where start date is less than todays date and item is not marked complete

		foreach ($users as $user)
		{
			$pids = $this->em->getRepository('AppBundle\Entity\Pid')
				->findPidsForReminder($user->getId());

			if($pids)
			{
				$this->sendEmail($user, $pids);
			}



		}

		// outputs a message followed by a "\n"
		$output->writeln('Cool! Just sent some reminder emails');

		//release lock
		$this->release();



	}



	public function sendEmail($user, $pids)
	{
		$message = (new \Swift_Message('PID reminder'))
			->setFrom('info@acupuncture.org.uk')
			->setTo($user->getEmail())
			->setBody(
				$this->twig->render(
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

		$mailer = $this->mailer;
		$mailer->send($message);

		// or, you can also fetch the mailer service this way
		// $this->get('mailer')->send($message);





	}



}