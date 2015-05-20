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
            'getBlockCourse'       =>new \Twig_Function_Method($this, 'getBlockCourse'),
            'getBlockAccommodation'=>new \Twig_Function_Method($this, 'getBlockAccommodation'),
        );
    }

    public function getBlockCourse()
    {
        $booking=$this->session->get("booking");
        $course=$this->em->getRepository("BackSchoolBundle:Course")->find($booking['course']['id']);
        $date=\DateTime::createFromFormat('Y-m-d', $booking['course']['startDate']);
        if($course->getSchoolLocation()->getType() == 1)
            return '<h4>Course</h4>
                        <dl class="other-details">
                            <dt class="feature">Course Type:</dt><dd class="value">'.$course->getName().'</dd>
                            <dt class="feature">Duration:</dt><dd class="value">'.$booking['course']['duration'].' weeks</dd>
                            <dt class="feature">Starting date:</dt><dd class="value">'.$date->format("d F Y").'</dd>
                            <dt class="total-price">Price</dt><dd class="total-price-value">'.$course->calculePrice($booking['course']['duration']).' '.$course->getSchoolLocation()->getCurrency()->getCode().'</dd>
                        </dl>';
        else
        {
            $price=$this->em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['course']['duration']);
            return '<h4>Course</h4>
                        <dl class="other-details">
                            <dt class="feature">Course Type:</dt><dd class="value">'.$course->getSubject().'</dd>
                            <dt class="feature">Duration:</dt><dd class="value">'.$price->getName().'</dd>
                            <dt class="feature">Starting date:</dt><dd class="value">'.$date->format("d F Y").'</dd>
                            <dt class="total-price">Price</dt><dd class="total-price-value">'.$course->calculePathwayPrice($booking['course']['duration']).' '.$course->getSchoolLocation()->getCurrency()->getCode().'</dd>
                        </dl>';
        }
    }

    public function getBlockAccommodation()
    {
        $booking=$this->session->get("booking");
        if(isset($booking['accommodation']) && count($booking['accommodation']) > 0)
        {
            $accommodation=$this->em->getRepository("BackSchoolBundle:Accommodation")->find($booking['accommodation']['id']);
            $room=$this->em->getRepository("BackSchoolBundle:Room")->find($booking['accommodation']['room']);
            if($accommodation->getSchoolLocation()->getType() == 1)
                return '<h4>Accommodation</h4>
                        <dl class="other-details">
                            <dt class="feature">Name :</dt><dd class="value">'.$accommodation->getName().'</dd>
                            <dt class="feature">Room:</dt><dd class="value">'.$room->getName().'</dd>
                            <dt class="feature">Duration:</dt><dd class="value">'.$booking['accommodation']['duration'].' weeks</dd>
                            <dt class="total-price">Price</dt><dd class="total-price-value">'.$room->calculePrice($booking['accommodation']['duration']).' '.$accommodation->getSchoolLocation()->getCurrency()->getCode().'</dd>
                        </dl>';
            else
            {
                $price=$this->em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['accommodation']['duration']);
                return '<h4>Accommodation</h4>
                        <dl class="other-details">
                            <dt class="feature">Name:</dt><dd class="value">'.$accommodation->getName().'</dd>
                            <dt class="feature">Room:</dt><dd class="value">'.$room->getName().'</dd>
                            <dt class="feature">Duration:</dt><dd class="value">'.$price->getStartDate()->format('d F Y').' to '.$price->getEndDate()->format('d F Y').'</dd>
                            <dt class="total-price">Price</dt><dd class="total-price-value">'.$price->getPrice().' '.$accommodation->getSchoolLocation()->getCurrency()->getCode().'</dd>
                        </dl>';
            }
        }
    }

    public function getName()
    {
        return 'BookingExtension';
    }

}
