<?php

namespace Back\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{

    public function ajaxClientAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $id=$request->get("id");
        $tab=array();
        $response=new JsonResponse();
        $user=new \Back\UserBundle\Entity\User();
        $user=$em->getRepository("BackUserBundle:User")->find($request->get('id'));
        $tab['title']=$user->__toString();
        $tab['data']['Firstname']=$user->getFirstName();
        $tab['data']['Lastname']=$user->getLastName();
        $tab['data']['Phone']=$user->getPhone();
        $tab['data']['Address']=$user->getAddress();
        $tab['data']['username']=$user->getUsername();
        $tab['data']['email']=$user->getEmail();
        $tab['data']['Last Login']=$user->getLastLogin()->format('d F Y H:i');
        $response->setData($tab);
        return $response;
    }

    public function ajaxStatusAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $id=$request->get("id");
        $type=$request->get("type");
        $tab=array();
        $response=new JsonResponse();
        if($type == 1)
            $status=$em->getRepository("BackBookingBundle:Status")->findBy(array( 'bookingLanguageCourse'=>$em->getRepository("FrontGeneralBundle:BookingLanguageCourse")->find($id)),array('id'=>'desc'));
        if($type == 2)
            $status=$em->getRepository("BackBookingBundle:Status")->findBy(array( 'bookingAccommodation'=>$em->getRepository("FrontGeneralBundle:BookingAccommodation")->find($id) ),array('id'=>'desc'));
        $tab['title']='list of status';
        foreach($status as $stat)
        {
            $t=array();
            $t['date']=$stat->getDate()->format('d F Y H:i');
            $t['user']=$stat->getUser()->__toString();
            $t['status']=$stat->getStatus()->__toString();
            $t['observation']=$stat->getObservation();
            $tab['data'][]=$t;
        }
        $response->setData($tab);
        return $response;
    }

}
