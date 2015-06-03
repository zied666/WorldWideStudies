<?php

namespace Back\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class LanguageCourseController extends Controller
{

    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $request=$this->getRequest();
        $query=$em->getRepository("FrontGeneralBundle:BookingLanguageCourse")->findBy(array(), array( 'id'=>'desc' ));
        $paginator=$this->get('knp_paginator');
        $bookings=$paginator->paginate($query, $request->query->get('page', 1), 10);
        return $this->render('BackBookingBundle:LanguageCourse:list.html.twig', array(
                    'bookings'=>$bookings
        ));
    }

}
