<?php

namespace Back\SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\SchoolBundle\Entity\School;
use Back\SchoolBundle\Entity\Course;
use Back\SchoolBundle\Form\CourseType;
use Back\SchoolBundle\Entity\StartDate;
use Back\SchoolBundle\Form\StartDateType;

class CoursesController extends Controller
{

    public function listCoursesAction(School $school)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $course=new Course();
        $course->setSchool($school);
        $form=$this->createForm(new CourseType(), $course);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $course=$form->getData();
                $em->persist($course);
                $em->flush();
                $session->getFlashBag()->add('success', "Your course has been added successfully");
                return $this->redirect($this->generateUrl("list_courses", array( 'id'=>$school->getId() )));
            }
        }
        return $this->render("BackSchoolBundle:courses:list.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$school,
        ));
    }

    public function deleteCoursesAction(Course $course)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($course);
            $em->flush();
            $session->getFlashBag()->add('success', " Your course has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This course is used by another table ');
        }
        return $this->redirect($this->generateUrl("list_courses", array( 'id'=>$course->getSchool()->getId() )));
    }

    public function editCoursesAction(School $school, Course $course)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $form=$this->createForm(new CourseType(), $course);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $course=$form->getData();
                $em->persist($course);
                $em->flush();
                $session->getFlashBag()->add('success', "Your course has been edited successfully");
                return $this->redirect($this->generateUrl("edit_courses", array(
                                    'id'    =>$school->getId(),
                                    'course'=>$course->getId(),
                )));
            }
        }
        return $this->render("BackSchoolBundle:courses:edit.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$school,
                    'course'=>$course,
        ));
    }

    public function startDateAction(School $school, Course $course)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $startDate=new StartDate();
        $startDate->setCourse($course);
        $form=$this->createForm(new StartDateType(), $startDate);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $startDate=$form->getData();
                $verif=$em->getRepository("BackSchoolBundle:StartDate")->findBy(array( 'course'=>$course, 'date'=>$startDate->getDate() ));
                if(count($verif) == 0)
                {
                    $em->persist($startDate);
                    $em->flush();
                    $session->getFlashBag()->add('success', "Your start date has been edited successfully");
                }
                else
                    $session->getFlashBag()->add('danger', "this date already exists");
                return $this->redirect($this->generateUrl("startdate_courses", array(
                                    'id'    =>$school->getId(),
                                    'course'=>$course->getId(),
                )));
            }
        }
        return $this->render("BackSchoolBundle:courses:startDates.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$school,
                    'course'=>$course,
        ));
    }

    public function deleteStartDateAction(StartDate $startDate)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($startDate);
            $em->flush();
            $session->getFlashBag()->add('success', " Your date has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This date is used by another table ');
        }
        return $this->redirect($this->generateUrl("startdate_courses", array(
                            'id'    =>$startDate->getCourse()->getSchool()->getId(),
                            'course'=>$startDate->getCourse()->getId()
        )));
    }

}
