<?php

namespace Back\SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;
use Back\SchoolBundle\Entity\SchoolLocation;
use Back\SchoolBundle\Entity\Course;
use Back\SchoolBundle\Form\CourseType;
use Back\SchoolBundle\Entity\StartDate;
use Back\SchoolBundle\Form\StartDateType;
use Back\SchoolBundle\Entity\Price;
use Back\SchoolBundle\Form\PriceType;
use Back\SchoolBundle\Form\GenerateDatesType;
use Symfony\Component\HttpFoundation\Response;
use Back\SchoolBundle\Entity\PathwayPrice;
use Back\SchoolBundle\Form\PathwayPriceType;
use Back\SchoolBundle\Entity\CourseSubject;
use Back\SchoolBundle\Form\CourseSubjectType;
use Back\SchoolBundle\Entity\Description;
use Back\SchoolBundle\Form\DescriptionType;

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
        $form2=$this->createForm(new GenerateDatesType());
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
                    'form2' =>$form2->createView(),
                    'school'=>$schoolLocation,
                    'course'=>$course,
        ));
    }

    public function GenerateDatesAction(Course $course)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $form=$this->createForm(new GenerateDatesType());
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            $data=$form->getData();
            if($data['startDate']->format('Y-m-d') < $data['endDate']->format('Y-m-d'))
            {
                $dates=$this->getDatesBetween($data['startDate']->format('Y-m-d'), $data['endDate']->format('Y-m-d'));
                $i=0;
                foreach($dates as $date)
                {
                    $jour=new \DateTime($date);
                    if(
                            ($jour->format('l') == 'Monday' && $data['monday']) ||
                            ($jour->format('l') == 'Tuesday' && $data['tuesday']) ||
                            ($jour->format('l') == 'Wednesday' && $data['wednesday']) ||
                            ($jour->format('l') == 'Thursday' && $data['thursday']) ||
                            ($jour->format('l') == 'Friday' && $data['friday']) ||
                            ($jour->format('l') == 'Saturday' && $data['saturday'])
                    )
                    {
                        $verif=$em->getRepository("BackSchoolBundle:StartDate")->findBy(array( 'course'=>$course, 'date'=>$jour ));
                        if(count($verif) == 0)
                        {
                            $i++;
                            $startDate=new StartDate();
                            $startDate->setCourse($course);
                            $startDate->setDate($jour);
                            $em->persist($startDate);
                        }
                    }
                }
                if($i != 0)
                {
                    $em->flush();
                    $session->getFlashBag()->add('success', "$i dates was added successfully");
                }
            }
            else
                $session->getFlashBag()->add('danger', "this date already exists");

            return $this->redirect($this->generateUrl("startdate_courses", array(
                                'id'    =>$course->getSchoolLocation()->getId(),
                                'course'=>$course->getId()
            )));
        }
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

    public function getDatesBetween($dStart, $dEnd)
    {
        $iStart=strtotime($dStart);
        $iEnd=strtotime($dEnd);
        if(false === $iStart || false === $iEnd)
        {
            return false;
        }
        $aStart=explode('-', $dStart);
        $aEnd=explode('-', $dEnd);
        if(count($aStart) !== 3 || count($aEnd) !== 3)
        {
            return false;
        }
        if(false === checkdate($aStart[1], $aStart[2], $aStart[0]) || false === checkdate($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart)
        {
            return false;
        }
        for($i=$iStart; $i < $iEnd + 86400; $i=strtotime('+1 day', $i))
        {
            $sDateToArr=strftime('%Y-%m-%d', $i);
            $sYear=substr($sDateToArr, 0, 4);
            $sMonth=substr($sDateToArr, 5, 2);
            //$aDates[$sYear][$sMonth][]=$sDateToArr;
            $aDates[]=$sDateToArr;
        }
        if(isset($aDates) && !empty($aDates))
        {
            return $aDates;
        }
        else
        {
            return false;
        }
    }

    public function deleteAllDatesAction(Course $course)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        foreach($course->getStartDates() as $date)
        {
            $em->remove($date);
        }
        $em->flush();
        $session->getFlashBag()->add('success', "All dates was deleted successfully");
        return $this->redirect($this->generateUrl("startdate_courses", array(
                            'id'    =>$course->getSchoolLocation()->getId(),
                            'course'=>$course->getId()
        )));
    }

    public function pathwayPriceAction(SchoolLocation $schoolLocation, Course $course)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $price=new PathwayPrice();
        $form=$this->createForm(new PathwayPriceType(), $price);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $price=$form->getData();
                $em->persist($price->setCourse($course));
                $em->flush();
                $session->getFlashBag()->add('success', "Your price has been added successfully");
                return $this->redirect($this->generateUrl("pathway_price_courses", array(
                                    'id'    =>$schoolLocation->getId(),
                                    'course'=>$course->getId(),
                )));
            }
        }
        return $this->render("BackSchoolBundle:courses:pathway_prices.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation,
                    'course'=>$course,
        ));
    }

    public function deletePathwayPriceAction(PathwayPrice $price)
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
        return $this->redirect($this->generateUrl("pathway_price_courses", array(
                            'id'    =>$price->getCourse()->getSchoolLocation()->getId(),
                            'course'=>$price->getCourse()->getId()
        )));
    }

    public function courseSubjectAction(Course $course, $id2)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if(is_null($id2))
            $courseSubject=new CourseSubject();
        else
            $courseSubject=$em->getRepository("BackSchoolBundle:CourseSubject")->find($id2);
        $form=$this->createForm(new CourseSubjectType(), $courseSubject);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $courseSubject=$form->getData();
                $em->persist($courseSubject->setCourse($course));
                $em->flush();
                $session->getFlashBag()->add('success', "Your course subject has been added successfully");
                return $this->redirect($this->generateUrl("course_subject", array(
                                    'id' =>$course->getId(),
                                    'id2'=>$id2,
                )));
            }
        }
        return $this->render("BackSchoolBundle:courses:course_subject.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$course->getSchoolLocation(),
                    'course'=>$course,
        ));
    }

    public function deleteCourseSubjectAction(CourseSubject $courseSubject)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($courseSubject);
            $em->flush();
            $session->getFlashBag()->add('success', " Your course Subject has been removed successfully");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This Course subject is used by another table ');
        }
        return $this->redirect($this->generateUrl("course_subject", array(
                            'id'=>$courseSubject->getCourse()->getId(),
        )));
    }

    public function descriptionAction(Course $course, $id2)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if(is_null($id2))
            $description=new Description();
        else
            $description=$em->getRepository("BackSchoolBundle:Description")->find($id2);
        $form=$this->createForm(new DescriptionType(), $description)
                ->add('courseSubject', "entity", array(
                            'class'=>'BackSchoolBundle:CourseSubject',
                            'query_builder'=>function(EntityRepository $er) use ($course){
                            return $er->createQueryBuilder('c')
                                    ->where('c.course = :id')
                                    ->setParameter('id', $course->getId());
                            
            }
        ));
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $description=$form->getData();
                $em->persist($description);
                $em->flush();
                $session->getFlashBag()->add('success', "Your description has been added successfully");
                return $this->redirect($this->generateUrl("course_subject_description", array(
                                    'id' =>$course->getId(),
                                    'id2'=>$id2,
                )));
            }
        }
        return $this->render("BackSchoolBundle:courses:description.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$course->getSchoolLocation(),
                    'course'=>$course,
        ));
    }

    public function deleteDescriptionAction(Description $description)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($description);
            $em->flush();
            $session->getFlashBag()->add('success', " Your course Subject has been removed successfully");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This description is used by another table ');
        }
        return $this->redirect($this->generateUrl("course_subject_description", array(
                            'id'=>$courseSubject->getCourse()->getId(),
        )));
    }

}
