<?php

namespace Back\SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\SchoolBundle\Entity\SchoolLocation;
use Back\SchoolBundle\Entity\Course;
use Back\SchoolBundle\Form\CourseType;
use Back\SchoolBundle\Entity\StartDate;
use Back\SchoolBundle\Form\StartDateType;
use Back\SchoolBundle\Entity\Price;
use Back\SchoolBundle\Form\PriceType;

class CoursesController extends Controller
{

    public function listCoursesAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $course=new Course();
        $course->setSchoolLocation($schoolLocation);
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
                return $this->redirect($this->generateUrl("list_courses", array( 'id'=>$schoolLocation->getId() )));
            }
        }
        return $this->render("BackSchoolBundle:courses:list.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation,
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
        return $this->redirect($this->generateUrl("list_courses", array( 'id'=>$course->getSchoolLocation()->getId() )));
    }

    public function editCoursesAction(SchoolLocation $schoolLocation, Course $course)
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
                                    'id'    =>$schoolLocation->getId(),
                                    'course'=>$course->getId(),
                )));
            }
        }
        return $this->render("BackSchoolBundle:courses:edit.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation,
                    'course'=>$course,
        ));
    }

    public function startDateAction(SchoolLocation $schoolLocation, Course $course)
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
                                    'id'    =>$schoolLocation->getId(),
                                    'course'=>$course->getId(),
                )));
            }
        }
        return $this->render("BackSchoolBundle:courses:startDates.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation,
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
                            'id'    =>$startDate->getCourse()->getSchoolLocation()->getId(),
                            'course'=>$startDate->getCourse()->getId()
        )));
    }

    public function priceAction(SchoolLocation $schoolLocation, Course $course)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $price=new Price();
        $price->setCourse($course);
        $form=$this->createForm(new PriceType(), $price);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $price=$form->getData();
                if($this->isValidPrice($course, $price))
                {
                    $em->persist($price);
                    $em->flush();
                    $session->getFlashBag()->add('success', "Your price has been added successfully");
                    return $this->redirect($this->generateUrl("price_courses", array(
                                        'id'    =>$schoolLocation->getId(),
                                        'course'=>$course->getId(),
                    )));
                }
                else
                    $session->getFlashBag()->add('danger', "Please verif your weeks");
            }
        }
        return $this->render("BackSchoolBundle:courses:prices.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation,
                    'course'=>$course,
        ));
    }

    public function isValidPrice(Course $course, Price $price)
    {
        if($price->getWeekStart() > $price->getWeekEnd())
            return FALSE;
        else
        {
            foreach($course->getPrices() as $prix)
            {
                if($price->getWeekStart() >= $prix->getWeekStart() && $price->getWeekStart() <= $prix->getWeekEnd())
                    return false;
                if($price->getWeekEnd() >= $prix->getWeekStart() && $price->getWeekEnd() <= $prix->getWeekEnd())
                    return false;
            }
        }
        return true;
    }

    public function deletePriceAction(Price $price)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($price);
            $em->flush();
            $session->getFlashBag()->add('success', " Your price has been removed successfully");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This price is used by another table ');
        }
        return $this->redirect($this->generateUrl("price_courses", array(
                            'id'    =>$price->getCourse()->getSchoolLocation()->getId(),
                            'course'=>$price->getCourse()->getId()
        )));
    }

}
