<?php

namespace Front\GeneralBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Doctrine\ORM\EntityManager;

class MyFirstListener
{

    public $session;
    public $em;
    public $router;
    public $mailer;
    public $securityContext;
    protected $templating;

    public function __construct(ContainerInterface $container, Session $session, EntityManager $em, $templating)
    {
        $this->session=$session;
        $this->em=$em;
        $this->router=$container->get('router');
        $this->mailer=$container->get('mailer');
        $this->securityContext=$container->get('security.context');
        $this->templating=$templating;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $route=$event->getRequest()->attributes->get('_route');
        if($route == 'dashboard')
        {
            $bookings=$this->em->getRepository('FrontGeneralBundle:BookingLanguageCourse')->findBy(array( 'notified'=>null ));
            foreach($bookings as $booking)
            {
                if(date('Y-m-d', strtotime($booking->getStartingDateCourse()->format('Y-m-d')." +15 days")) <= date('Y-m-d'))
                {
                    $contact=$this->em->getRepository("BackGeneralBundle:Contact")->find(1);
                    $message=\Swift_Message::newInstance()
                            ->setSubject("Booking validation")
                            ->setFrom($contact->getEmail())
                            ->setTo($booking->getClient()->getEmail())
                            ->setContentType('text/html')
                            ->setBody($this->templating->render('FrontGeneralBundle:Booking:emailNotified.html.twig', array(
                                'booking'=>$booking,
                                'type'   =>'course',
                    )));
                    $this->mailer->send($message);
                    $this->em->persist($booking->setNotified(true));
                    $this->em->flush();
                }
            }
            $bookings=$this->em->getRepository('FrontGeneralBundle:BookingAccommodation')->findBy(array( 'notified'=>null ));
            foreach($bookings as $booking)
            {
                if(date('Y-m-d', strtotime($booking->getStartingDate()->format('Y-m-d')." +15 days")) <= date('Y-m-d'))
                {
                    $contact=$this->em->getRepository("BackGeneralBundle:Contact")->find(1);
                    $message=\Swift_Message::newInstance()
                            ->setSubject("Booking validation")
                            ->setFrom($contact->getEmail())
                            ->setTo($booking->getClient()->getEmail())
                            ->setContentType('text/html')
                            ->setBody($this->templating->render('FrontGeneralBundle:Booking:emailNotified.html.twig', array(
                                'booking'=>$booking,
                                'type'   =>'accommodation',
                    )));
                    $this->mailer->send($message);
                    $this->em->persist($booking->setNotified(true));
                    $this->em->flush();
                }
            }
        }
    }

}
