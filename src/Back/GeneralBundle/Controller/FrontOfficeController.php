<?php

namespace Back\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\GeneralBundle\Entity\Contact;
use Back\GeneralBundle\Form\ContactType;
use Back\GeneralBundle\Entity\Slider;
use Back\GeneralBundle\Form\SliderType;

class FrontOfficeController extends Controller
{

    public function contactAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $contact=$em->getRepository("BackGeneralBundle:Contact")->find(1);
        if(!$contact)
            $contact=new Contact();
        $form=$this->createForm(new ContactType(), $contact);
        if($this->getRequest()->isMethod("POST"))
        {
            $form->submit($this->getRequest());
            if($form->isValid())
            {
                $contact=$form->getData();
                $em->persist($contact);
                $em->flush();
                $session->getFlashBag()->add('success', "Page contact has been updated successfully");
                return $this->redirect($this->generateUrl("backoffice_contact"));
            }
        }
        return $this->render('BackGeneralBundle:FrontOffice:contact.html.twig', array(
                    'form'=>$form->createView()
        ));
    }

    public function sliderAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if(is_null($id))
            $slider=new Slider();
        else
            $slider=$em->getRepository("BackGeneralBundle:Slider")->find($id);
        $form=$this->createForm(new SliderType(), $slider);
        $sliders=$em->getRepository("BackGeneralBundle:Slider")->findBy(array(), array('ordre'=>'asc'));
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $slider=$form->getData();
                $em->persist($slider);
                $em->flush();
                $session->getFlashBag()->add('success', "Your slider has been updated successfully");
                return $this->redirect($this->generateUrl("backoffice_slider"));
            }
        }
        return $this->render('BackGeneralBundle:FrontOffice:slider.html.twig', array(
                    'form'   =>$form->createView(),
                    'sliders'=>$sliders
        ));
    }

    public function deleteSliderAction(Slider $slider)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $em->remove($slider);
        $em->flush();
        $session->getFlashBag()->add('success', "Your slider has been updated successfully");
        return $this->redirect($this->generateUrl("backoffice_slider"));
    }

}
