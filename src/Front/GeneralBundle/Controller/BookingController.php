<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Back\SchoolBundle\Entity\SchoolLocation;

class BookingController extends Controller
{

    public function bookRedirectAction(SchoolLocation $school)
    {
        $session=$this->getRequest()->getSession();
        if($session->has("booking"))
            $session->remove("booking");
        $session->set("booking", array( 'school'=>$school->getId() ));
        return $this->redirect($this->generateUrl("book_school_step1"));
    }

    public function step1Action()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        dump($session->get("booking"));
        $booking=$session->get("booking");
        $school=$em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        return $this->render('FrontGeneralBundle:Booking:step1.html.twig', array(
                    'school'=>$school,
        ));
    }

}
