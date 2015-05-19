<?php

namespace Front\GeneralBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\SchoolBundle\Entity\Course;

class BookingExtension extends \Twig_Extension
{

    protected $em;
    protected $session;

    public function __construct(EntityManager $em, Session $session)
    {
        $this->em=$em;
        $this->session=$session;
    }

    public function getFunctions()
    {
        return array(
            'getNameCourse'=>new \Twig_Function_Method($this, 'getNameCourse'),
            'getDuration'  =>new \Twig_Function_Method($this, 'getDuration'),
            'getPriceCourse'  =>new \Twig_Function_Method($this, 'getPriceCourse'),
            'getStartingDate'  =>new \Twig_Function_Method($this, 'getStartingDate'),
        );
    }

    public function getNameCourse()
    {
        $booking=$this->session->get("booking");
        $course=new Course();
        $course=$this->em->getRepository("BackSchoolBundle:Course")->find($booking['course']['id']);
        if($course->getSchoolLocation()->getType() == 1)
            return $course->getName();
        else
            return $course->getSubject();
    }

    public function getDuration()
    {
        $booking=$this->session->get("booking");
        $course=new Course();
        $course=$this->em->getRepository("BackSchoolBundle:Course")->find($booking['course']['id']);
        if($course->getSchoolLocation()->getType() == 1)
            return $booking['course']['duration'].' weeks';
        else
        {
            $price=$this->em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['course']['duration']);
            return $price->getName();
        }
    }

    public function getPriceCourse()
    {
        $booking=$this->session->get("booking");
        $course=new Course();
        $course=$this->em->getRepository("BackSchoolBundle:Course")->find($booking['course']['id']);
        if($course->getSchoolLocation()->getType() == 1)
            return $course->calculePrice($booking['course']['duration']).' '.$course->getSchoolLocation()->getCurrency()->getCode();
        else
            return $course->calculePathwayPrice($booking['course']['duration']).' '.$course->getSchoolLocation()->getCurrency()->getCode();
    }
    
    public function getStartingDate()
    {
        $booking=$this->session->get("booking");
        //$date = new \DateTime($booking['course']['startDate']);
        $date =\DateTime::createFromFormat('Y-m-d',  $booking['course']['startDate']);
        return $date->format("d F Y");
    }

    public function getName()
    {
        return 'BookingExtension';
    }

}
