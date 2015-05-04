<?php

namespace Back\UniversityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\UniversityBundle\Entity\University;
use Back\UniversityBundle\Form\UniversityType;
use Back\UniversityBundle\Entity\CourseTitle;
use Back\UniversityBundle\Form\CourseTitleType;
use Back\UniversityBundle\Entity\StartDate;
use Back\UniversityBundle\Form\StartDateType;

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
                $session->getFlashBag()->add('success', "Your university has been updated successfully");
                return $this->redirect($this->generateUrl("list_university"));
            }
        }
        return $this->render('BackUniversityBundle::add.html.twig', array(
                    'university'=>$university,
                    'form'      =>$form->createView()
        ));
    }

    public function enableAction(University $university)
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

    public function deleteCourseTitleAction(CourseTitle $courseTitle)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($courseTitle);
            $em->flush();
            $session->getFlashBag()->add('success', " Your Course Title has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This Course Title is used by another table ');
        }
        return $this->redirect($this->generateUrl("course_title", array(
                            'id'=>$courseTitle->getUniversity()->getId()
        )));
    }

    public function courseTitleAction(University $university, $id2)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id2 == null)
            $courseTitle=new CourseTitle();
        else
            $courseTitle=$em->getRepository("BackUniversityBundle:CourseTitle")->find($id2);
        $form=$this->createForm(new CourseTitleType(), $courseTitle);
        if($this->getRequest()->isMethod("POST"))
        {
            $form->submit($this->getRequest());
            if($form->isValid())
            {
                $courseTitle=$form->getData();
                $em->persist($courseTitle->setUniversity($university));
                $em->flush();
                $session->getFlashBag()->add('success', "Your Course title has been updated successfully");
                return $this->redirect($this->generateUrl("course_title", array(
                                    'id'=>$university->getId()
                )));
            }
        }
        return $this->render('BackUniversityBundle::course_title.html.twig', array(
                    'university' =>$university,
                    'courseTitle'=>$courseTitle,
                    'form'       =>$form->createView()
        ));
    }

    public function startingDateAction(CourseTitle $courseTitle)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $startDate=new StartDate();
        $form=$this->createForm(new StartDateType(), $startDate);
        if($this->getRequest()->isMethod("Post"))
        {
            $form->submit($this->getRequest());
            if($form->isValid())
            {
                $startDate=$form->getData();
                $em->persist($startDate->setCourseTitle($courseTitle));
                $em->flush();
                $session->getFlashBag()->add('success', "Your Start Date has been updated successfully");
                return $this->redirect($this->generateUrl("course_title_startingdate",array('id'=>$courseTitle->getId())));
            }
        }
        return $this->render('BackUniversityBundle::starting_date.html.twig', array(
                    'university'=>$courseTitle->getUniversity(),
                    'courseTitle'=>$courseTitle,
                    'form'       =>$form->createView()
        ));
    }
    
    public function deleteStartingDateAction(StartDate $startDate)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($startDate);
            $em->flush();
            $session->getFlashBag()->add('success', " Your Start Date Title has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This Start Date Title is used by another table ');
        }
        return $this->redirect($this->generateUrl("course_title_startingdate", array(
                            'id'=>$startDate->getCourseTitle()->getId()
        )));
    }
    
}
