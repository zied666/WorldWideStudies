<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Front\GeneralBundle\Entity\FormStep1;
use Front\GeneralBundle\Entity\FormStep2;
use Front\GeneralBundle\Entity\FormStep3;
use Front\GeneralBundle\Entity\FormStep4;
use Front\GeneralBundle\Form\FormStep1Type;
use Front\GeneralBundle\Form\FormStep2Type;
use Front\GeneralBundle\Form\FormStep3Type;
use Front\GeneralBundle\Form\FormStep4Type;

class FormProgramPathwayController extends Controller
{

    public function step1Action()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if(!$session->has('booking_pathway'))
            $booking['step1']=null;
        else
            $booking=$session->get('booking_pathway');
        if(is_null($booking['step1']))
            $step1=new FormStep1();
        else
            $step1=$em->getRepository('FrontGeneralBundle:FormStep1')->find($booking['step1']);
        $form=$this->createForm(new FormStep1Type(), $step1);
        $request=$this->getRequest();
        if($request->isMethod('POST'))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $step1=$form->getData();
                $em->persist($step1->setBookingDate(new \DateTime()));
                $em->flush();
                $booking['step1']=$step1->getId();
                $session->set('booking_pathway', $booking);
                return $this->redirect($this->generateUrl('front_program_pathway_step2'));
            }
        }
        return $this->render('FrontGeneralBundle:Booking\ProgramPathway:step1.html.twig', array(
                    'form'=>$form->createView(),
        ));
    }

    public function step2Action()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $booking=$session->get('booking_pathway');
        if(!isset($booking['step2']))
            $booking['step2']=null;
        if(is_null($booking['step2']))
            $step2=new FormStep2();
        else
            $step2=$em->getRepository('FrontGeneralBundle:FormStep2')->find($booking['step2']);
        $form=$this->createForm(new FormStep2Type(), $step2);
        $request=$this->getRequest();
        if($request->isMethod('POST'))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $step1=$em->getRepository('FrontGeneralBundle:FormStep1')->find($booking['step1']);
                $step2=$form->getData();
                $em->persist($step2->setFormStep1($step1));
                $em->persist($step1->setFormStep2($step2));
                $em->flush();
                $booking['step2']=$step2->getId();
                $session->set('booking_pathway', $booking);
                return $this->redirect($this->generateUrl('front_program_pathway_step3'));
            }
        }
        return $this->render('FrontGeneralBundle:Booking\ProgramPathway:step2.html.twig', array(
                    'form'=>$form->createView(),
        ));
    }

    public function step3Action()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $booking=$session->get('booking_pathway');
        if(!isset($booking['step3']))
            $booking['step3']=null;
        if(is_null($booking['step3']))
            $step3=new FormStep3();
        else
            $step3=$em->getRepository('FrontGeneralBundle:FormStep3')->find($booking['step3']);
        $form=$this->createForm(new FormStep3Type(), $step3);
        $request=$this->getRequest();
        if($request->isMethod('POST'))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $step2=$em->getRepository('FrontGeneralBundle:FormStep2')->find($booking['step2']);
                $step3=$form->getData();
                $em->persist($step3);
                $em->persist($step2->setFormStep3($step3));
                $em->flush();
                $booking['step3']=$step3->getId();
                $session->set('booking_pathway', $booking);
                return $this->redirect($this->generateUrl('front_program_pathway_step4'));
            }
        }
        return $this->render('FrontGeneralBundle:Booking\ProgramPathway:step3.html.twig', array(
                    'form'=>$form->createView(),
        ));
    }

    public function step4Action()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $booking=$session->get('booking_pathway');
        if(!isset($booking['step4']))
            $booking['step4']=null;
        if(is_null($booking['step4']))
            $step4=new FormStep4();
        else
            $step4=$em->getRepository('FrontGeneralBundle:FormStep4')->find($booking['step4']);
        $form=$this->createForm(new FormStep4Type(), $step4);
        $request=$this->getRequest();
        if($request->isMethod('POST'))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $step3=$em->getRepository('FrontGeneralBundle:FormStep3')->find($booking['step3']);
                $step4=$form->getData();
                $em->persist($step4);
                $em->persist($step3->setFormStep4($step4));
                $em->flush();
                $session->remove("booking_pathway");
                return $this->redirect($this->generateUrl('front_program_pathway_step_thikyou'));
            }
        }
        return $this->render('FrontGeneralBundle:Booking\ProgramPathway:step4.html.twig', array(
                    'form'=>$form->createView(),
        ));
    }

    public function thinkyouAction()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        return $this->render('FrontGeneralBundle:Booking\ProgramPathway:thinkyou.html.twig');
    }

}
