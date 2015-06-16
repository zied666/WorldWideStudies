<?php

namespace Back\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Back\BookingBundle\Entity\Status;
use Back\BookingBundle\Form\StatusType;
use Front\GeneralBundle\Entity\FormStep1;

class PathwayCourseController extends Controller
{

    public function detailsAction(FormStep1 $step1)
    {
        return $this->render('BackBookingBundle:Formulaires:details.html.twig', array(
                    'step1'=>$step1,
        ));
    }

    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $user=$this->get('security.context')->getToken()->getUser();
        $request=$this->getRequest();
        $status=new Status();
        $form=$this->createForm(new StatusType(), $status)
                ->remove('bookingLanguageCourse')
                ->remove('bookingAccommodation')
                ->add('formStep1');
        $this->deleteforms();
        if($request->isMethod('post'))
        {
            $form->submit($request);
            $status=$form->getData();
            $em->persist($status->setDate(new \DateTime())->setUser($user));
            $em->flush();
            $session->getFlashBag()->add('success', "Your status has been added successfully");
            return $this->redirect($this->generateUrl("back_list_pathway_course"));
        }
        $query=$em->getRepository("FrontGeneralBundle:FormStep1")->findBy(array(), array( 'id'=>'desc' ));
        $paginator=$this->get('knp_paginator');
        $bookings=$paginator->paginate($query, $request->query->get('page', 1), 20);
        return $this->render('BackBookingBundle:Formulaires:list.html.twig', array(
                    'bookings'=>$bookings,
                    'form'    =>$form->createView()
        ));
    }

    public function deleteforms()
    {
        $em=$this->getDoctrine()->getManager();
        $steps=$em->getRepository("FrontGeneralBundle:FormStep1")->findBy(array( 'formStep2'=>null ));
        foreach($steps as $step)
        {
            $em->remove($step);
            $em->flush();
        }
        $steps=$em->getRepository("FrontGeneralBundle:FormStep2")->findBy(array( 'formStep3'=>null ));
        foreach($steps as $step)
        {
            if(is_null($step->getFormStep3()) || is_null($step->getFormStep3()->getFormStep4()))
            {
                $em->remove($step);
                $em->flush();
            }
        }
        $steps=$em->getRepository("FrontGeneralBundle:FormStep3")->findBy(array( 'formStep4'=>null ));
        foreach($steps as $step)
        {
            if(is_null($step->getFormStep4()))
            {
                $em->remove($step);
                $em->flush();
            }
        }
    }

}
