<?php

namespace Back\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccommodationController extends Controller
{

    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $request=$this->getRequest();
        $query=$em->getRepository("FrontGeneralBundle:BookingAccommodation")->findBy(array(), array( 'id'=>'desc' ));
        $paginator=$this->get('knp_paginator');
        $bookings=$paginator->paginate($query, $request->query->get('page', 1), 20);
        return $this->render('BackBookingBundle:Accommodation:list.html.twig', array(
                    'bookings'=>$bookings
        ));
    }

    public function ajaxPaypalAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $id=$request->get("id");
        $tab=array();
        $response=new JsonResponse();
        $booking=$em->getRepository("FrontGeneralBundle:BookingAccommodation")->find($request->get('id'));
        $tab['title']='Paypal information';
        $tab['data']=$booking->getPaypalData();
        $response->setData($tab);
        return $response;
    }

}
