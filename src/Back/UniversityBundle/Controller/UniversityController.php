<?php

namespace Back\UniversityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\UniversityBundle\Entity\University;
use Back\UniversityBundle\Form\UniversityType;

class UniversityController extends Controller
{

    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $request=$this->getRequest();
        $query=$em->getRepository("BackUniversityBundle:University")->findBy(array(), array( 'id'=>'desc' ));
        $paginator=$this->get('knp_paginator');
        $universities=$paginator->paginate($query, $request->query->get('page', 1), 10);
        return $this->render('BackUniversityBundle::list.html.twig', array(
                    'universities'=>$universities
        ));
    }

    public function addAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == null)
            $university=new University();
        else
            $university=$em->getRepository("BackUniversityBundle:University")->find($id);
        $form=$this->createForm(new UniversityType(), $university);
        if($this->getRequest()->isMethod("POST"))
        {
            $form->submit($this->getRequest());
            if($form->isValid())
            {
                $university=$form->getData();
                $em->persist($university->setEnabled(TRUE));
                $em->flush();
                $session->getFlashBag()->add('success', "Your university has been updates successfully");
                return $this->redirect($this->generateUrl("list_university"));
            }
        }
        return $this->render('BackUniversityBundle::add.html.twig', array(
                    'university'=>$university,
                    'form'=>$form->createView()
        ));
    }
    
    public function enableSchoolAction(University $university)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($university->isEnabled())
            $university->setEnabled(FALSE);
        else
            $university->setEnabled(TRUE);
        $em->persist($university);
        $em->flush();
        $session->getFlashBag()->add('success', "Your university has been updates successfully");
        return $this->redirect($this->generateUrl("list_university"));
    }
    
    public function deleteAction(University $university)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();

        try
        {
            $em->remove($university);
            $em->flush();
            $session->getFlashBag()->add('success', " Your university has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This university is used by another table ');
        }
        return $this->redirect($this->generateUrl("list_university"));
    }
}
