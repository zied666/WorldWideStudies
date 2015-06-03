<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Back\SchoolBundle\Entity\SchoolLocation;
use Back\SchoolBundle\Entity\Room;
use Back\AccommodationBundle\Entity\Accommodation;
use Front\GeneralBundle\Entity\BookingLanguageCourse;
use Front\GeneralBundle\Entity\BookingPathwayCourse;
use Front\GeneralBundle\Entity\BookingAccommodation;

class BookingController extends Controller
{

    public function bookRedirectSchoolAction(SchoolLocation $school)
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
            $response->setData(array(
                'price'=>$this->get('library')->convertCurrency($price->getPrice(), $course->getSchoolLocation()->getCurrency()->getCode())
            ));
        }
        if($course->getSchoolLocation()->getType() == 1)
        {
            $price=$course->calculePrice($request->get('val'));
            $response->setData(array(
                'price'=>$this->get('library')->convertCurrency($price, $course->getSchoolLocation()->getCurrency()->getCode())
            ));
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
            $response->setData(array(
                'price'=>$this->get('library')->convertCurrency($price->getPrice(), $accommodation->getSchoolLocation()->getCurrency()->getCode())
            ));
        }
        if($accommodation->getSchoolLocation()->getType() == 1)
        {
            $price=$room->calculePrice($request->get('val'));
            $response->setData(array(
                'price'=>$this->get('library')->convertCurrency($price, $accommodation->getSchoolLocation()->getCurrency()->getCode())
            ));
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
//            $price=$room->calculePrice($room->getMinWeek()).' '.$room->getAccommodation()->getSchoolLocation()->getCurrency()->getCode();
            $price=$this->get('library')->convertCurrency($room->calculePrice($room->getMinWeek()), $room->getAccommodation()->getSchoolLocation()->getCurrency()->getCode());
        }
        if($room->getAccommodation()->getSchoolLocation()->getType() == 2)
        {
            foreach($room->getPathwayPrices() as $price)
                $tab[$price->getId()]=$price->getStartDate()->format('d F Y').' - '.$price->getEndDate()->format('d F Y');
//            $price=$room->calculePathwayPrice($room->getPathwayPrices()->first()->getId()).' '.$room->getAccommodation()->getSchoolLocation()->getCurrency()->getCode();
            $price=$this->get('library')->convertCurrency($room->calculePathwayPrice($room->getPathwayPrices()->first()->getId()), $room->getAccommodation()->getSchoolLocation()->getCurrency()->getCode());
        }
        $response->setData(array( 'select'=>$tab, 'price'=>$price ));
        return $response;
    }

    public function step1Action()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
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
        return $this->render('FrontGeneralBundle:Booking\Schools:step1.html.twig', array(
                    'school'=>$school,
        ));
    }

    public function step2Action()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
        $booking=$session->get("booking");
        $request=$this->getRequest();
        if($request->isMethod("post"))
        {
            $acco=$request->get('accommodation');
            $booking["accommodation"]=array();
            if(!is_null($acco))
            {
                $booking["accommodation"]=array( 'id'=>$acco, 'room'=>$request->get('room_'.$acco), 'duration'=>$request->get('duration_'.$acco), 'startDate'=>$this->container->get('library')->convertDate($request->get('startDate_'.$acco)) );
            }
            $session->set("booking", $booking);
            return $this->redirect($this->generateUrl("book_school_step3"));
        }
        $school=$em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        return $this->render('FrontGeneralBundle:Booking\Schools:step2.html.twig', array(
                    'school'=>$school,
        ));
    }

    public function step3Action()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
        $booking=$session->get("booking");
        $school=$em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        $request=$this->getRequest();
        if($request->isMethod('POST'))
        {
            $tabExtras=array();
            foreach($school->getExtras() as $extra)
            {
                if($extra->getObligatory() || $request->get('extra_'.$extra->getId()))
                    $tabExtras[]=$extra->getId();
            }
            $booking['extras']=$tabExtras;
            $session->set("booking", $booking);
            return $this->redirect($this->generateUrl('book_school_review'));
        }
        return $this->render('FrontGeneralBundle:Booking\Schools:step3.html.twig', array(
                    'school' =>$school,
                    'booking'=>$booking,
        ));
    }

    public function reviewCourseAction()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
        $booking=$session->get("booking");
        $school=$em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        return $this->render('FrontGeneralBundle:Booking\Schools:review.html.twig', array(
                    'school'=>$school,
        ));
    }

    public function thinkyouCourseAction()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
        $booking=$session->get("booking");
        $school=$em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        return $this->render('FrontGeneralBundle:Booking\Schools:thinkyou.html.twig', array(
                    'school'=>$school,
        ));
    }

    public function paypalCourseAction()
    {
        $em=$this->getDoctrine()->getManager();
        $paypal=$em->getRepository("BackReferentielBundle:Paypal")->find(1);
        $request=$this->getRequest();
        $email_account=$paypal->getAccount();
        $req='cmd=_notify-validate';

        foreach($_POST as $key=> $value)
        {
            $value=urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        $header="POST /cgi-bin/webscr HTTP/1.0\r\n";
        if($paypal->getTestMode())
            $header .= "Host: www.sandbox.paypal.com\r\n";
        else
            $header .= "Host: www.paypal.com\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: ".strlen($req)."\r\n\r\n";
        if($paypal->getTestMode())
            $fp=fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        else
            $fp=fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);
        $item_name=$_POST['item_name'];
        $item_number=$_POST['item_number'];
        $payment_status=$_POST['payment_status'];
        $payment_amount=$_POST['mc_gross'];
        $payment_currency=$_POST['mc_currency'];
        $txn_id=$_POST['txn_id'];
        $receiver_email=$_POST['receiver_email'];
        $payer_email=$_POST['payer_email'];
        parse_str($_POST['custom'], $custom);
        $booking=$em->getRepository("FrontGeneralBundle:".$custom['entity'])->find($custom['id']);
        file_put_contents('log', print_r($_POST, true));
        if(!$fp)
        {
            
        }
        else
        {
            fputs($fp, $header.$req);
            while(!feof($fp))
            {
                $res=fgets($fp, 1024);
                if(strcmp($res, "VERIFIED") == 0)
                {
                    if($payment_status == "Completed" || ( $paypal->getTestMode() && $payment_status=='Pending'))
                    {
                        if($email_account == $receiver_email)
                        {
                            if($payment_amount == $booking->getTotal() && $payment_currency==$booking->getCurrency()->getCode())
                            {
                                $booking->setDateTrasaction(new \DateTime());
                                $booking->setIdTransaction($_POST['txn_id']);
                                $booking->setStatus(2);
                                $booking->setPaypalData($_POST);
                                $em->persist($booking);
                                $em->flush();
                            }
                            else
                            {
                                
                            }
                        }
                    }
                    else
                    {
                        
                    }
                    exit();
                }
                else if(strcmp($res, "INVALID") == 0)
                {
                    
                }
            }
            fclose($fp);
        }
    }

    public function bookRedirectAccommodationAction(Accommodation $accommodation)
    {
        $session=$this->getRequest()->getSession();
        if($session->has("booking"))
            $session->remove("booking");
        $session->set("booking", array( 'accommodation'=>$accommodation->getId() ));
        return $this->redirect($this->generateUrl("book_accommodation_step1"));
    }

    public function step1AccommodationAction()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
        $booking=$session->get("booking");
        $request=$this->getRequest();
        if($request->isMethod("post"))
        {
            $room=$request->get('room');
            $booking["room"]=$room;
            $booking["price"]=$request->get('price_'.$room);
            $booking["startDate"]=$this->container->get('library')->convertDate($request->get('startDate_'.$room));
            $session->set("booking", $booking);
            return $this->redirect($this->generateUrl("book_accommodation_review"));
        }
        $accommodation=$em->getRepository("BackAccommodationBundle:Accommodation")->find($booking['accommodation']);
        return $this->render('FrontGeneralBundle:Booking\Accommodation:step1.html.twig', array(
                    'accommodation'=>$accommodation,
        ));
    }

    public function ajaxUpdatePriceAccommodationAction()
    {
        $em=$this->getDoctrine()->getManager();
        $response=new JsonResponse();
        $request=$this->getRequest();
        $room=$em->getRepository("BackAccommodationBundle:Room")->find($request->get('room'));
        $accommodation=$room->getAccommodation();
        $response->setData(array(
            'price'=>$this->get('library')->convertCurrency($room->calculePrice($request->get('val')), $accommodation->getCurrency()->getCode())
        ));
        return $response;
    }

    public function reviewAccommodationAction()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
        $booking=$session->get("booking");
        $accommodation=$em->getRepository("BackAccommodationBundle:Accommodation")->find($booking['accommodation']);
        return $this->render('FrontGeneralBundle:Booking\Accommodation:review.html.twig', array(
                    'accommodation'=>$accommodation,
        ));
    }

    public function thinkyouAccommodationAction()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
        $booking=$session->get("booking");
        $accommodation=$em->getRepository("BackAccommodationBundle:Accommodation")->find($booking['accommodation']);
        return $this->render('FrontGeneralBundle:Booking\Accommodation:thinkyou.html.twig', array(
                    'accommodation'=>$accommodation,
        ));
    }

    public function validationLanguageCourseAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $user=$this->get('security.context')->getToken()->getUser();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
        $booking=$session->get("booking");
        $curr=$session->get("currency");
        $currency=$em->getRepository("BackReferentielBundle:Currency")->findOneBy(array( 'code'=>$curr['code'] ));
        $bookingLanguageCourse=new BookingLanguageCourse();
        $bookingLanguageCourse->setClient($user);
        $bookingLanguageCourse->setCurrency($currency);
        $school=$em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        //Course
        $course=$em->getRepository("BackSchoolBundle:Course")->find($booking['course']['id']);
        $bookingLanguageCourse->setCourse($course);
        $bookingLanguageCourse->setWeekCourse($booking['course']['duration']);
        $bookingLanguageCourse->setStartingDateCourse(\DateTime::createFromFormat('Y-m-d', $booking['course']['startDate']));
        $bookingLanguageCourse->setTotalCourse($this->container->get('library')->convertCurrency($course->calculePrice($booking['course']['duration']), $school->getCurrency()->getCode()));
        //Accommodation 
        $totalAccommodation=0;
        if(isset($booking['accommodation']['id']))
        {
            $room=$em->getRepository("BackSchoolBundle:Room")->find($booking['accommodation']['room']);
            $bookingLanguageCourse->setRoom($room);
            $bookingLanguageCourse->setWeekAccommodation($booking['accommodation']['duration']);
            $bookingLanguageCourse->setStartingDateAccommodation(\DateTime::createFromFormat('Y-m-d', $booking['accommodation']['startDate']));
            $totalAccommodation=$this->container->get('library')->convertCurrency($room->calculePrice($booking['accommodation']['duration']), $school->getCurrency()->getCode());
        }
        $bookingLanguageCourse->setTotalAccommodation($totalAccommodation);
        //Extras
        $totalExtra=0;
        foreach($booking['extras'] as $ext)
        {
            $extra=$em->getRepository("BackSchoolBundle:Extra")->find($ext);
            $bookingLanguageCourse->addExtra($extra);
            $totalExtra +=$this->container->get('booking')->getPriceExtra($ext);
        }
        $bookingLanguageCourse->setTotalExtra($this->container->get('library')->convertCurrency($totalExtra, $school->getCurrency()->getCode()));
        $bookingLanguageCourse->setTotal($bookingLanguageCourse->getTotalCourse() + $bookingLanguageCourse->getTotalAccommodation() + $bookingLanguageCourse->getTotalExtra());
        $em->persist($bookingLanguageCourse->setStatus(1)->setBookingDate(new \DateTime()));
        $em->flush();
//        return $this->redirect($this->generateUrl('book_school_thinkyou'));
        $paypal=$em->getRepository('BackReferentielBundle:Paypal')->find(1);
        return $this->render("FrontGeneralBundle:Booking\Schools:sendToPaypal.html.twig", array(
                    'paypal' =>$paypal,
                    'booking'=>$bookingLanguageCourse
        ));
    }

    public function validationPathwayCourseAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $user=$this->get('security.context')->getToken()->getUser();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
        $booking=$session->get("booking");
        $curr=$session->get("currency");
        $currency=$em->getRepository("BackReferentielBundle:Currency")->findOneBy(array( 'code'=>$curr['code'] ));
        $bookingPahwayCourse=new BookingPathwayCourse();
        $bookingPahwayCourse->setClient($user);
        $bookingPahwayCourse->setCurrency($currency);
        $school=$em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        //Course
        $course=$em->getRepository("BackSchoolBundle:Course")->find($booking['course']['id']);
        $pathwayPrice=$em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['course']['duration']);
        $bookingPahwayCourse->setCourse($course);
        $bookingPahwayCourse->setPathwayPriceCourse($pathwayPrice);
        $bookingPahwayCourse->setStartingDateCourse(\DateTime::createFromFormat('Y-m-d', $booking['course']['startDate']));
        $bookingPahwayCourse->setTotalCourse($this->container->get('library')->convertCurrency($pathwayPrice->getPrice(), $school->getCurrency()->getCode()));
        //Accommodation 
        $totalAccommodation=0;
        if(isset($booking['accommodation']['id']))
        {
            $room=$em->getRepository("BackSchoolBundle:Room")->find($booking['accommodation']['room']);
            $pathwayPrice=$em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['accommodation']['duration']);
            $bookingPahwayCourse->setRoom($room);
            $bookingPahwayCourse->setPathwayPriceAccommodation($pathwayPrice);
            $bookingPahwayCourse->setStartingDateAccommodation(\DateTime::createFromFormat('Y-m-d', $booking['accommodation']['startDate']));
            $totalAccommodation=$this->container->get('library')->convertCurrency($pathwayPrice->getPrice(), $school->getCurrency()->getCode());
        }
        $bookingPahwayCourse->setTotalAccommodation();
        //Extras
        $totalExtra=0;
        foreach($booking['extras'] as $ext)
        {
            $extra=$em->getRepository("BackSchoolBundle:Extra")->find($ext);
            $bookingPahwayCourse->addExtra($extra);
            $totalExtra +=$this->container->get('booking')->getPriceExtra($ext);
        }
        $bookingPahwayCourse->setTotalExtra($this->container->get('library')->convertCurrency($totalExtra, $school->getCurrency()->getCode()));
        $bookingPahwayCourse->setTotal($bookingPahwayCourse->getTotalCourse() + $bookingPahwayCourse->getTotalAccommodation() + $bookingPahwayCourse->getTotalExtra());
        $em->persist($bookingPahwayCourse->setStatus(1)->setBookingDate(new \DateTime()));
        $em->flush();
//        $session->getFlashBag()->add('success', "Your booking has been done successfully");
        return $this->redirect($this->generateUrl('book_school_thinkyou'));
    }

    public function validationAccommodationAction()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        $user=$this->get('security.context')->getToken()->getUser();
        if(!$session->has("booking"))
            return $this->redirect($this->generateUrl('accueil'));
        $curr=$session->get("currency");
        $currency=$em->getRepository("BackReferentielBundle:Currency")->findOneBy(array( 'code'=>$curr['code'] ));
        $booking=$session->get("booking");
        $bookingAccommodation=new BookingAccommodation();
        $accommodation=$em->getRepository("BackAccommodationBundle:Accommodation")->find($booking['accommodation']);
        $room=$em->getRepository("BackAccommodationBundle:Room")->find($booking['room']);
        $price=$em->getRepository("BackAccommodationBundle:Price")->find($booking['price']);
        $bookingAccommodation->setClient($user);
        $bookingAccommodation->setCurrency($currency);
        $bookingAccommodation->setRoom($room);
        $bookingAccommodation->setPrice($price);
        $bookingAccommodation->setStartingDate(\DateTime::createFromFormat('Y-m-d', $booking['startDate']));
        $bookingAccommodation->setTotal($this->container->get('library')->convertCurrency($price->getPrice(), $accommodation->getCurrency()->getCode()));
//        $em->persist($bookingAccommodation->setStatus(1)->setBookingDate(new \DateTime()));
        $em->flush();
        return $this->redirect($this->generateUrl('book_accommodation_thinkyou'));
    }

}
