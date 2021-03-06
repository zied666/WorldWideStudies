<?php

namespace Front\GeneralBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\SchoolBundle\Entity\Course;
use Back\SchoolBundle\Entity\Extra;
use Symfony\Component\DependencyInjection\Container;

class BookingExtension extends \Twig_Extension
{

    protected $em;
    protected $session;
    protected $container;

    public function __construct(EntityManager $em, Session $session, Container $container)
    {
        $this->em=$em;
        $this->session=$session;
        $this->container=$container;
    }

    public function getFunctions()
    {
        return array(
            'getBlockCourse'        =>new \Twig_Function_Method($this, 'getBlockCourse'),
            'getBlockAccommodation' =>new \Twig_Function_Method($this, 'getBlockAccommodation'),
            'getPriceExtra'         =>new \Twig_Function_Method($this, 'getPriceExtra'),
            'testAccommodation'     =>new \Twig_Function_Method($this, 'testAccommodation'),
            'GetReview'             =>new \Twig_Function_Method($this, 'GetReview'),
            'GetReviewAccommodation'=>new \Twig_Function_Method($this, 'GetReviewAccommodation'),
        );
    }

    public function getBlockCourse()
    {
        $booking=$this->session->get("booking");
        $showDate='';
        $block='';
        $course=$this->em->getRepository("BackSchoolBundle:Course")->find($booking['course']['id']);
        $date=\DateTime::createFromFormat('Y-m-d', $booking['course']['startDate']);
        if($booking['course']['startDate'] != '')
            $showDate=$date->format("d F Y");
        if($course->getSchoolLocation()->getType() == 1)
        {
            $block.='<h4>Course</h4>';
            $block.= '<dl class="other-details">';
            $block.= '<dt class="feature">Course Type:</dt><dd class="value">'.$course->getName().'</dd>';
            $block.= '<dt class="feature">Duration:</dt><dd class="value">'.$booking['course']['duration'].' weeks</dd>';
            $block.= '<dt class="feature">Starting date:</dt><dd class="value">'.$showDate.'</dd>';
//            $block.= '<dt class="total-price">Price</dt><dd class="total-price-value">'.$course->calculePrice($booking['course']['duration']).' '.$course->getSchoolLocation()->getCurrency()->getCode().'</dd>';
            $block.= '<dt class="total-price">Price</dt><dd class="total-price-value">'.$this->container->get('library')->convertCurrency($course->calculePrice($booking['course']['duration']), $course->getSchoolLocation()->getCurrency()->getCode()).'</dd>';
            $block.= '</dl>';
        }
        else
        {
            $price=$this->em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['course']['duration']);
            $block.='<h4>Course</h4>';
            $block.='<dl class="other-details">';
            $block.='<dt class="feature">Course Type:</dt><dd class="value">'.$course->getSubject().'</dd>';
            $block.='<dt class="feature">Duration:</dt><dd class="value">'.$price->getName().'</dd>';
            $block.='<dt class="feature">Starting date:</dt><dd class="value">'.$date->format("d F Y").'</dd>';
//            $block.='<dt class="total-price">Price</dt><dd class="total-price-value">'.$course->calculePathwayPrice($booking['course']['duration']).' '.$course->getSchoolLocation()->getCurrency()->getCode().'</dd>';
            $block.='<dt class="total-price">Price</dt><dd class="total-price-value">'.$this->container->get('library')->convertCurrency($course->calculePathwayPrice($booking['course']['duration']), $course->getSchoolLocation()->getCurrency()->getCode()).'</dd>';
            $block.='</dl>';
        }
        return $block;
    }

    public function getBlockAccommodation()
    {
        $booking=$this->session->get("booking");
        $showDate='';
        $block='';
        if(isset($booking['accommodation']['startDate']) && $booking['accommodation']['startDate'] != '')
        {
            $date=\DateTime::createFromFormat('Y-m-d', $booking['accommodation']['startDate']);
            $showDate=$date->format("d F Y");
        }
        if(isset($booking['accommodation']) && count($booking['accommodation']) > 0)
        {
            $accommodation=$this->em->getRepository("BackSchoolBundle:Accommodation")->find($booking['accommodation']['id']);
            $room=$this->em->getRepository("BackSchoolBundle:Room")->find($booking['accommodation']['room']);
            if($accommodation->getSchoolLocation()->getType() == 1)
            {
                $block.='<h4>Accommodation</h4>';
                $block.='<dl class="other-details">';
                $block.='<dt class="feature">Name :</dt><dd class="value">'.$accommodation->getName().'</dd>';
                $block.='<dt class="feature">Room:</dt><dd class="value">'.$room->getName().'</dd>';
                $block.='<dt class="feature">Duration:</dt><dd class="value">'.$booking['accommodation']['duration'].' weeks</dd>';
                $block.='<dt class="feature">Starting date:</dt><dd class="value">'.$showDate.'</dd>';
//                $block.='<dt class="total-price">Price</dt><dd class="total-price-value">'.$room->calculePrice($booking['accommodation']['duration']).' '.$accommodation->getSchoolLocation()->getCurrency()->getCode().'</dd>';
                $block.='<dt class="total-price">Price</dt><dd class="total-price-value">'.$this->container->get('library')->convertCurrency($room->calculePrice($booking['accommodation']['duration']), $accommodation->getSchoolLocation()->getCurrency()->getCode()).'</dd>';
                $block.='</dl>';
            }
            else
            {
                $price=$this->em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['accommodation']['duration']);
                $block.='<h4>Accommodation</h4>';
                $block.='<dl class="other-details">';
                $block.='<dt class="feature">Name:</dt><dd class="value">'.$accommodation->getName().'</dd>';
                $block.='<dt class="feature">Room:</dt><dd class="value">'.$room->getName().'</dd>';
                $block.='<dt class="feature">Duration:</dt><dd class="value">'.$price->getStartDate()->format('d F Y').' to '.$price->getEndDate()->format('d F Y').'</dd>';
//                $block.='<dt class="total-price">Price</dt><dd class="total-price-value">'.$price->getPrice().' '.$accommodation->getSchoolLocation()->getCurrency()->getCode().'</dd>';
                $block.='<dt class="total-price">Price</dt><dd class="total-price-value">'.$this->container->get('library')->convertCurrency($price->getPrice(), $accommodation->getSchoolLocation()->getCurrency()->getCode()).'</dd>';
                $block.='</dl>';
            }
        }
        return $block;
    }

    public function getPriceExtra($id)
    {
        $booking=$this->session->get("booking");
        $extra=$this->em->getRepository("BackSchoolBundle:Extra")->find($id);
        $school=$this->em->getRepository("BackSchoolBundle:SchoolLocation")->find($booking['school']);
        if($extra->getPerWeek() == 1)
        {
            if($school->getType() == 1)
                return($extra->getPrice() * $booking['course']['duration']);
            if($school->getType() == 2)
            {
                $price=$this->em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['course']['duration']);
                return($extra->getPrice() * $price->getWeek());
            }
        }
        elseif($extra->getPerWeek() == 2)
        {
            if($school->getType() == 1)
                return($extra->getPrice() * $booking['accommodation']['duration']);
            if($school->getType() == 2)
            {
                $price=$this->em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['accommodation']['duration']);
                return($extra->getPrice() * $price->getNumbrerWeeks());
            }
        }
        else
            return $extra->getPrice();
    }

    public function testAccommodation($id)
    {
        $booking=$this->session->get("booking");
        $extra=$this->em->getRepository("BackSchoolBundle:Extra")->find($id);
        if($extra->getPerWeek() == 2)
        {
            if(isset($booking['accommodation']['duration']))
                return true;
            else
                return false;
        }
        else
            return TRUE;
    }

    public function GetReview()
    {
        $booking=$this->session->get("booking");
        $course=$this->em->getRepository("BackSchoolBundle:Course")->find($booking['course']['id']);
        $date=\DateTime::createFromFormat('Y-m-d', $booking['course']['startDate']);
        $showDate="";
        if($booking['course']['startDate'] != '')
            $showDate=$date->format("d F Y");
        $block='';
        $total=0;
        if($course->getSchoolLocation()->getType() == 1)
        {
            $block.= '<h4>Course</h4>';
            $block.= '<dl class="other-details">';
            $block.= '<dt class="feature">Course Type:</dt><dd class="value">'.$course->getName().'</dd>';
            $block.= '<dt class="feature">Duration:</dt><dd class="value">'.$booking['course']['duration'].' weeks</dd>';
            $block.= '<dt class="feature">Starting date:</dt><dd class="value">'.$showDate.'</dd>';
//            $block.= '<dt class="total-price">Price</dt><dd class="total-price-value" style="color: #01b7f2;">'.$course->calculePrice($booking['course']['duration']).' '.$course->getSchoolLocation()->getCurrency()->getCode().'</dd>';
            $block.= '<dt class="total-price">Price</dt><dd class="total-price-value" style="color: #01b7f2;">'.$this->container->get('library')->convertCurrency($course->calculePrice($booking['course']['duration']), $course->getSchoolLocation()->getCurrency()->getCode()).'</dd>';
            $block.= '</dl>';
            $total+=$course->calculePrice($booking['course']['duration']);
        }
        else
        {
            $price=$this->em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['course']['duration']);
            $block.= '<h4>Course</h4>';
            $block.= '<dl class="other-details">';
            $block.= '<dt class="feature">Course Type:</dt><dd class="value">'.$course->getSubject().'</dd>';
            $block.= '<dt class="feature">Duration:</dt><dd class="value">'.$price->getName().'</dd>';
            $block.= '<dt class="feature">Starting date:</dt><dd class="value">'.$date->format("d F Y").'</dd>';
//            $block.= '<dt class="total-price">Price</dt><dd class="total-price-value" style="color: #01b7f2;">'.$course->calculePathwayPrice($booking['course']['duration']).' '.$course->getSchoolLocation()->getCurrency()->getCode().'</dd>';
            $block.= '<dt class="total-price">Price</dt><dd class="total-price-value" style="color: #01b7f2;">'.$this->container->get('library')->convertCurrency($course->calculePathwayPrice($booking['course']['duration']), $course->getSchoolLocation()->getCurrency()->getCode()).'</dd>';
            $block.= '</dl>';
            $total+=$course->calculePathwayPrice($booking['course']['duration']);
        }
        if(isset($booking['accommodation']) && count($booking['accommodation']) > 0)
        {
            $date=\DateTime::createFromFormat('Y-m-d', $booking['accommodation']['startDate']);
            if($booking['accommodation']['startDate'] != '')
                $showDate=$date->format("d F Y");
            $accommodation=$this->em->getRepository("BackSchoolBundle:Accommodation")->find($booking['accommodation']['id']);
            $room=$this->em->getRepository("BackSchoolBundle:Room")->find($booking['accommodation']['room']);
            if($accommodation->getSchoolLocation()->getType() == 1)
            {
                $block.= '<div class="clearfix" style="  margin-top: 160px;"></div>';
                $block.= '<h4>Accommodation</h4>';
                $block.= '<dl class="other-details">';
                $block.= '<dt class="feature">Name :</dt><dd class="value">'.$accommodation->getName().'</dd>';
                $block.= '<dt class="feature">Room:</dt><dd class="value">'.$room->getName().'</dd>';
                $block.= '<dt class="feature">Duration:</dt><dd class="value">'.$booking['accommodation']['duration'].' weeks</dd>';
                $block.= '<dt class="feature">Starting date:</dt><dd class="value">'.$showDate.'</dd>';
//                $block.= '<dt class="total-price">Price</dt><dd class="total-price-value" style="color: #01b7f2;">'.$room->calculePrice($booking['accommodation']['duration']).' '.$accommodation->getSchoolLocation()->getCurrency()->getCode().'</dd>';
                $block.= '<dt class="total-price">Price</dt><dd class="total-price-value" style="color: #01b7f2;">'.$this->container->get('library')->convertCurrency($room->calculePrice($booking['accommodation']['duration']), $accommodation->getSchoolLocation()->getCurrency()->getCode()).'</dd>';
                $block.= '</dl>';
                $total+=$room->calculePrice($booking['accommodation']['duration']);
            }
            else
            {
                $price=$this->em->getRepository("BackSchoolBundle:PathwayPrice")->find($booking['accommodation']['duration']);
                $block.= '<div class="clearfix" style="  margin-top: 160px;"></div>';
                $block.= '<h4>Accommodation</h4>';
                $block.= '<dl class="other-details">';
                $block.= '<dt class="feature">Name:</dt><dd class="value">'.$accommodation->getName().'</dd>';
                $block.= '<dt class="feature">Room:</dt><dd class="value">'.$room->getName().'</dd>';
                $block.= '<dt class="feature">Duration:</dt><dd class="value">'.$price->getStartDate()->format('d F Y').' to '.$price->getEndDate()->format('d F Y').'</dd>';
//                $block.= '<dt class="total-price">Price</dt><dd class="total-price-value" style="color: #01b7f2;">'.$price->getPrice().' '.$accommodation->getSchoolLocation()->getCurrency()->getCode().'</dd>';
                $block.= '<dt class="total-price">Price</dt><dd class="total-price-value" style="color: #01b7f2;">'.$this->container->get('library')->convertCurrency($price->getPrice(), $accommodation->getSchoolLocation()->getCurrency()->getCode()).'</dd>';
                $block.= '</dl>';
                $total+=$price->getPrice();
            }
        }

        if(count($booking['extras']) > 0)
        {
            $block.= '<div class="clearfix"></div>';
            $block.='<h4>Extras</h4>';
            $block.='<dl class="other-details">';
            foreach($booking['extras'] as $id)
            {
                $extra=$this->em->getRepository("BackSchoolBundle:Extra")->find($id);
                $block.='<dt class="feature">'.$extra->getName().'</dt>';
//                $block.='<dd class="value" style="color: #01b7f2;">'.$this->getPriceExtra($id).' '.$course->getSchoolLocation()->getCurrency()->getCode().'</dd>';
                $block.='<dd class="value" style="color: #01b7f2;">'.$this->container->get('library')->convertCurrency($this->getPriceExtra($id), $course->getSchoolLocation()->getCurrency()->getCode()).'</dd>';
                $total+=$this->getPriceExtra($id);
            }
            $block.= '</dl>';
        }

        $block.= '<div class="clearfix"></div>';
        $block.='<hr><h4>Total</h4>';
        $block.='<dl class="other-details">';
//        $block.='<dt class="feature">Total</dt><dd class="value" style="color: #01b7f2;">'.$total.' '.$course->getSchoolLocation()->getCurrency()->getCode().'</dd>';
        $block.='<dt class="feature">Total</dt><dd class="value" style="color: #01b7f2;">'.$this->container->get('library')->convertCurrency($total, $course->getSchoolLocation()->getCurrency()->getCode()).'</dd>';
        $block.='</dl>';
        return $block;
    }

    public function GetReviewAccommodation()
    {
        $booking=$this->session->get("booking");
        $block='';
        $accommodation=$this->em->getRepository("BackAccommodationBundle:Accommodation")->find($booking['accommodation']);
        $date=\DateTime::createFromFormat('Y-m-d', $booking['startDate']);
        $room=$this->em->getRepository("BackAccommodationBundle:Room")->find($booking['room']);
        $price=$this->em->getRepository("BackAccommodationBundle:Price")->find($booking['price']);
        $block.= '<h4>Accommodation</h4>';
        $block.= '<dl class="other-details">';
        $block.= '<dt class="feature">Name:</dt><dd class="value">'.$accommodation->getName().'</dd>';
        $block.= '<dt class="feature">Room:</dt><dd class="value">'.$room->getName().'</dd>';
        $block.= '<dt class="feature">Duration:</dt><dd class="value">'.$price->getStartDate()->format('d F Y').' to '.$price->getEndDate()->format('d F Y').'</dd>';
//        $block.= '<dt class="total-price">Price</dt><dd class="total-price-value" style="color: #01b7f2;">'.$price->getPrice().' '.$accommodation->getCurrency()->getCode().'</dd>';
        $block.= '<dt class="total-price">Price</dt><dd class="total-price-value">'.$this->container->get('library')->convertCurrency($price->getPrice(), $accommodation->getCurrency()->getCode()).'</dd>';
        $block.= '</dl>';
        return $block;
    }

    public function getName()
    {
        return 'BookingExtension';
    }

}
