<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Back\SchoolBundle\Entity\SchoolLocation;
use Back\SchoolBundle\Entity\Room;

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

    public function ajaxUpdatePriceCourseAction()
    {
        $em=$this->getDoctrine()->getManager();
        $response=new JsonResponse();
        $request=$this->getRequest();
        $course=$em->getRepository("BackSchoolBundle:Course")->find($request->get('course'));
        if($course->getSchoolLocation()->getType() == 2)
        {
            $price=$em->getRepository('BackSchoolBundle:PathwayPrice')->find($request->get('val'));
            $response->setData(array( 'price'=>$price->getPrice().' '.$course->getSchoolLocation()->getCurrency()->getCode() ));
        }
        if($course->getSchoolLocation()->getType() == 1)
        {
            $price=$course->calculePrice($request->get('val'));
            $response->setData(array( 'price'=>$price.' '.$course->getSchoolLocation()->getCurrency()->getCode() ));
        }
        return $response;
    }

    public function ajaxUpdatePriceAccoAction()
    {
        $em=$this->getDoctrine()->getManager();
        $response=new JsonResponse();
        $request=$this->getRequest();
        $room=$em->getRepository("BackSchoolBundle:Room")->find($request->get('room'));
        $accommodation=$room->getAccommodation();
        if($accommodation->getSchoolLocation()->getType() == 2)
        {
            $price=$em->getRepository('BackSchoolBundle:PathwayPrice')->find($request->get('val'));
            $response->setData(array( 'price'=>$price->getPrice().' '.$accommodation->getSchoolLocation()->getCurrency()->getCode() ));
        }
        if($accommodation->getSchoolLocation()->getType() == 1)
        {
            $price=$room->calculePrice($request->get('val'));
            $response->setData(array( 'price'=>$price.' '.$accommodation->getSchoolLocation()->getCurrency()->getCode() ));
        }
        return $response;
    }

    public function ajaxUpdateDurationAction()
    {
        $em=$this->getDoctrine()->getManager();
        $response=new JsonResponse();
        $request=$this->getRequest();
        $response=new JsonResponse();
        $room=new Room();
        $room=$em->getRepository("BackSchoolBundle:Room")->find($request->get('room'));
        $tab=array();
        $price=0;
        if($room->getAccommodation()->getSchoolLocation()->getType() == 1)
        {
            for($i=$room->getMinWeek(); $i <= $room->getMaxWeek(); $i++)
                $tab[$i]=$i.' weeks';
            $price=$room->calculePrice($room->getMinWeek()).' '.$room->getAccommodation()->getSchoolLocation()->getCurrency()->getCode();
        }
        if($room->getAccommodation()->getSchoolLocation()->getType() == 2)
        {
            foreach($room->getPathwayPrices() as $price)
                $tab[$price->getId()]=$price->getStartDate()->format('d F Y').' - '.$price->getEndDate()->format('d F Y');
            $price=$room->calculePathwayPrice($room->getPathwayPrices()->first()->getId()).' '.$room->getAccommodation()->getSchoolLocation()->getCurrency()->getCode();
        }
        $response->setData(array( 'select'=>$tab, 'price'=>$price ));
        return $response;
    }

    public function step1Action()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        $booking=$session->get("booking");
        $request=$this->getRequest();
        if($request->isMethod("post"))
        {
            $course=$request->get('course');
            $booking["course"]=array( 'id'=>$course, 'duration'=>$request->get('duration_'.$course), 'startDate'=>$request->get('startingDate_'.$course) );
            $session->set("booking", $booking);
            return $this->redirect($this->generateUrl("book_school_step2"));
        }
        $school=$em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        return $this->render('FrontGeneralBundle:Booking:step1.html.twig', array(
                    'school'=>$school,
        ));
    }

    public function step2Action()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        $booking=$session->get("booking");
        $request=$this->getRequest();
        if($request->isMethod("post"))
        {
            $acco=$request->get('accommodation');
            $booking["accommodation"]=array();
            if(!is_null($acco))
            {
                $booking["accommodation"]=array( 'id'=>$acco, 'room'=>$request->get('room_'.$acco), 'duration'=>$request->get('duration_'.$acco) );
            }
            $session->set("booking", $booking);
            return $this->redirect($this->generateUrl("book_school_step3"));
        }
        $school=$em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        return $this->render('FrontGeneralBundle:Booking:step2.html.twig', array(
                    'school'=>$school,
        ));
    }
    
    public function step3Action()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        $booking=$session->get("booking");
        $request=$this->getRequest();
        dump($booking);
        $school=$em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        return $this->render('FrontGeneralBundle:Booking:step3.html.twig', array(
                    'school'=>$school,
        ));
    }

}
