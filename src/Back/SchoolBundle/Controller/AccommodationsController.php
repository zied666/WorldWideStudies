<?php

namespace Back\SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;
use Back\SchoolBundle\Entity\Accommodation;
use Back\SchoolBundle\Form\AccommodationType;
use Back\SchoolBundle\Entity\SchoolLocation;
use Back\SchoolBundle\Entity\Room;
use Back\SchoolBundle\Form\RoomType;
use Back\SchoolBundle\Entity\Price;
use Back\SchoolBundle\Form\PriceType;
use Back\SchoolBundle\Entity\PathwayPrice;
use Back\SchoolBundle\Form\PathwayPriceType;

class AccommodationsController extends Controller
{

    public function listAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $accommodation=new Accommodation();
        $accommodation->setSchoolLocation($schoolLocation);
        $form=$this->createForm(new AccommodationType(), $accommodation);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $accommodation=$form->getData();
                $em->persist($accommodation);
                $em->flush();
                $session->getFlashBag()->add('success', "Your accommodation has been added successfully");
                return $this->redirect($this->generateUrl("list_accommodations", array( 'id'=>$schoolLocation->getId() )));
            }
        }
        return $this->render("BackSchoolBundle:accommodations:list.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation,
        ));
    }

    public function deleteAccommodationsAction(Accommodation $accommodation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($accommodation);
            $em->flush();
            $session->getFlashBag()->add('success', " Your accommodation has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This accommodation is used by another table ');
        }
        return $this->redirect($this->generateUrl("list_accommodations", array( 'id'=>$accommodation->getSchoolLocation()->getId() )));
    }

    public function editAccommodationsAction(SchoolLocation $schoolLocation, Accommodation $accommodation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $accommodation->setSchoolLocation($schoolLocation);
        $form=$this->createForm(new AccommodationType(), $accommodation);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $accommodation=$form->getData();
                $em->persist($accommodation);
                $em->flush();
                $session->getFlashBag()->add('success', "Your accommodation has been added successfully");
                return $this->redirect($this->generateUrl("list_accommodations", array(
                                    'id'           =>$schoolLocation->getId(),
                                    'accommodation'=>$accommodation->getId()
                )));
            }
        }
        return $this->render("BackSchoolBundle:accommodations:edit.html.twig", array(
                    'form'         =>$form->createView(),
                    'school'       =>$schoolLocation,
                    'accommodation'=>$accommodation,
        ));
    }

    public function roomsAction(SchoolLocation $schoolLocation, Accommodation $accommodation, $id2)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id2 == null)
            $room=new Room();
        else
            $room=$em->getRepository("BackSchoolBundle:Room")->find($id2);
        $form=$this->createForm(new RoomType, $room);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $room=$form->getData();
                $em->persist($room->setAccommodation($accommodation));
                $em->flush();
                $session->getFlashBag()->add('success', "Your room has been added successfully");
                return $this->redirect($this->generateUrl("rooms_accommodations", array(
                                    'id'           =>$schoolLocation->getId(),
                                    'accommodation'=>$accommodation->getId()
                )));
            }
        }
        return $this->render("BackSchoolBundle:accommodations:rooms.html.twig", array(
                    'form'         =>$form->createView(),
                    'school'       =>$schoolLocation,
                    'accommodation'=>$accommodation,
                    'room'         =>$room,
        ));
    }

    public function deleteRoomAction(Room $room)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($room);
            $em->flush();
            $session->getFlashBag()->add('success', " Your room has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This room is used by another table ');
        }
        return $this->redirect($this->generateUrl("rooms_accommodations", array(
                            'id'           =>$room->getAccommodation()->getSchoolLocation()->getId(),
                            'accommodation'=>$room->getAccommodation()->getId()
        )));
    }

    public function priceAction(SchoolLocation $schoolLocation, Accommodation $accommodation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $price=new Price();
        $form=$this
                ->createForm(new PriceType(), $price)
                ->add('room', "entity", array(
            'class'        =>'BackSchoolBundle:Room',
            'query_builder'=>function(EntityRepository $er) use ($accommodation){
                return $er->createQueryBuilder('r')
                        ->where('r.accommodation = :id')
                        ->setParameter('id', $accommodation->getId());
                ;
            }
        ));
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $price=$form->getData();
                if($this->isValidPrice($price))
                {
                    $em->persist($price);
                    $em->flush();
                    $session->getFlashBag()->add('success', "Your price has been added successfully");
                    return $this->redirect($this->generateUrl("price_accommodations", array(
                                        'id'           =>$schoolLocation->getId(),
                                        'accommodation'=>$accommodation->getId()
                    )));
                }
                else
                    $session->getFlashBag()->add('danger', "Please verif your weeks");
            }
        }
        return $this->render("BackSchoolBundle:accommodations:prices.html.twig", array(
                    'form'         =>$form->createView(),
                    'school'       =>$schoolLocation,
                    'accommodation'=>$accommodation,
        ));
    }

    public function deletePriceAction(Price $price)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($price);
            $em->flush();
            $session->getFlashBag()->add('success', " Your room has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This room is used by another table ');
        }
        return $this->redirect($this->generateUrl("price_accommodations", array(
                            'id'           =>$price->getRoom()->getAccommodation()->getSchoolLocation()->getId(),
                            'accommodation'=>$price->getRoom()->getAccommodation()->getId()
        )));
    }

    public function isValidPrice(Price $price)
    {
        foreach($price->getRoom()->getPrices() as $prix)
        {
            if($price->getWeekEnd() != $prix->getWeekEnd() || $price->getWeekStart() != $prix->getWeekStart() || $price->getPrice() != $prix->getPrice())
            {
                if($price->getWeekStart() >= $prix->getWeekStart() && $price->getWeekStart() <= $prix->getWeekEnd())
                    return false;
                if($price->getWeekEnd() >= $prix->getWeekStart() && $price->getWeekEnd() <= $prix->getWeekEnd())
                    return false;
            }
        }
        return true;
    }

    public function pathwayPriceAction(SchoolLocation $schoolLocation, Accommodation $accommodation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $price=new PathwayPrice();
        $form=$this
                ->createForm(new PathwayPriceType(), $price)
                ->add('room', "entity", array(
            'class'        =>'BackSchoolBundle:Room',
            'query_builder'=>function(EntityRepository $er) use ($accommodation){
                return $er->createQueryBuilder('r')
                        ->where('r.accommodation = :id')
                        ->setParameter('id', $accommodation->getId());
                ;
            }
        ));
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $price=$form->getData();
                $em->persist($price);
                $em->flush();
                $session->getFlashBag()->add('success', "Your price has been added successfully");
                return $this->redirect($this->generateUrl("pathway_price_accommodations", array(
                                    'id'           =>$schoolLocation->getId(),
                                    'accommodation'=>$accommodation->getId()
                )));
            }
        }
        return $this->render("BackSchoolBundle:accommodations:pathway_prices.html.twig", array(
                    'form'         =>$form->createView(),
                    'school'       =>$schoolLocation,
                    'accommodation'=>$accommodation,
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
            $session->getFlashBag()->add('success', " Your room has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This room is used by another table ');
        }
        return $this->redirect($this->generateUrl("pathway_price_accommodations", array(
                            'id'           =>$price->getRoom()->getAccommodation()->getSchoolLocation()->getId(),
                            'accommodation'=>$price->getRoom()->getAccommodation()->getId()
        )));
    }

}
