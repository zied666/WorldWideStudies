<?php

namespace Back\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class LanguageCourseController extends Controller
{

    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $request=$this->getRequest();
        $query=$em->getRepository("FrontGeneralBundle:BookingLanguageCourse")->findBy(array(), array( 'id'=>'desc' ));
        $paginator=$this->get('knp_paginator');
        $bookings=$paginator->paginate($query, $request->query->get('page', 1), 20);
        return $this->render('BackBookingBundle:LanguageCourse:list.html.twig', array(
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
        $booking=$em->getRepository("FrontGeneralBundle:BookingLanguageCourse")->find($request->get('id'));
        $tab['title']='Paypal information';
        $tab['data']=$booking->getPaypalData();
        $response->setData($tab);
        return $response;
    }

    public function ajaxCourseAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $id=$request->get("id");
        $tab=array();
        $tab=array();
        $response=new JsonResponse();
        $booking=new \Front\GeneralBundle\Entity\BookingLanguageCourse();
        $booking=$em->getRepository("FrontGeneralBundle:BookingLanguageCourse")->find($request->get('id'));
        $tab['title']=$booking->getCourse()->getName();
        $tab['data']=array();
        $tab['data']['Course']=$booking->getCourse()->getName();
        $tab['data']['Duration']=$booking->getWeekCourse().' weeks';
        $tab['data']['Starting date']=$booking->getStartingDateCourse()->format('l d/m/Y');
        $tab['data']['Price']=$booking->getTotalCourse().' '.$booking->getCurrency()->getCode();
        $response->setData($tab);
        return $response;
    }

    public function ajaxAccommodationAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $id=$request->get("id");
        $tab=array();
        $tab=array();
        $response=new JsonResponse();
        $booking=new \Front\GeneralBundle\Entity\BookingLanguageCourse();
        $booking=$em->getRepository("FrontGeneralBundle:BookingLanguageCourse")->find($request->get('id'));
        if(!is_null($booking->getRoom()))
        {
            $tab['title']=$booking->getRoom()->getAccommodation()->getName();
            $tab['data']=array();
            $tab['data']['Accommodation']=$booking->getRoom()->getAccommodation()->getName();
            $tab['data']['room']=$booking->getRoom()->getName();
            $tab['data']['Duration']=$booking->getWeekAccommodation().' weeks';
            $tab['data']['Starting date']=$booking->getStartingDateAccommodation()->format('l d/m/Y');
            $tab['data']['Price']=$booking->getTotalAccommodation().' '.$booking->getCurrency()->getCode();
            $response->setData($tab);
        }
        return $response;
    }

    public function ajaxExtrasAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $id=$request->get("id");
        $tab=array();
        $tab=array();
        $response=new JsonResponse();
        $booking=new \Front\GeneralBundle\Entity\BookingLanguageCourse();
        $booking=$em->getRepository("FrontGeneralBundle:BookingLanguageCourse")->find($request->get('id'));
        $tab['title']='Extras : '.count($booking->getExtras());
        $tab['data']=array();
        $i=0;
        foreach($booking->getExtras() as $extra)
        {
            $i++;
            $tab['data']['Extra : '.$i]=$extra->getName();
        }
       
        $response->setData($tab);
        return $response;
    }

}
