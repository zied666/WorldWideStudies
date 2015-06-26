<?php

namespace Back\AccommodationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;
use Back\AccommodationBundle\Entity\Accommodation;
use Back\AccommodationBundle\Form\AccommodationType;
use Back\ReferentielBundle\Entity\Media;
use Back\ReferentielBundle\Form\MediaType;
use Back\AccommodationBundle\Entity\Room;
use Back\AccommodationBundle\Form\RoomType;
use Back\AccommodationBundle\Entity\Price;
use Back\AccommodationBundle\Form\PriceType;

class AccommodationController extends Controller
{

    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $session=$this->getRequest()->getSession();
        $query=$em->getRepository("BackAccommodationBundle:Accommodation")->findBy(array(), array( 'id'=>'desc' ));

        $paginator=$this->get('knp_paginator');
        $accommodations=$paginator->paginate($query, $request->query->get('page', 1), 10);

        return $this->render('BackAccommodationBundle::list.html.twig', array(
                    'accommodations'=>$accommodations
        ));
    }

    public function addAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == null)
            $accommodation=new Accommodation();
        else
            $accommodation=$em->getRepository("BackAccommodationBundle:Accommodation")->find($id);
        $form=$this->createForm(new AccommodationType(), $accommodation);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $accommodation=$form->getData();
                $em->persist($accommodation->setEnabled(TRUE));
                $em->flush();
                $session->getFlashBag()->add('success', "Your Accommodation has been added successfully");
                return $this->redirect($this->generateUrl("add_accommodation", array( 'id'=>$id )));
            }
        }
        return $this->render('BackAccommodationBundle::add.html.twig', array(
                    'form'         =>$form->createView(),
                    'accommodation'=>$accommodation,
        ));
    }

    public function deleteAction(Accommodation $accommodation)
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
        return $this->redirect($this->generateUrl("list_accommodation"));
    }

    public function enableAction(Accommodation $accommodation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($accommodation->isEnabled())
            $accommodation->setEnabled(FALSE);
        else
            $accommodation->setEnabled(TRUE);
        $em->persist($accommodation);
        $em->flush();
        $session->getFlashBag()->add('success', "Your accommodation has been updates successfully");
        return $this->redirect($this->generateUrl("list_accommodation"));
    }

    public function galleryAction(Accommodation $accommodation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $media=new Media();
        $media->setAccommodation($accommodation);
        $form=$this->createForm(new MediaType, $media);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $media=$form->getData();
                $em->persist($media);
                $em->flush();
                $session->getFlashBag()->add('success', "Your photo has been added successfully");
                return $this->redirect($this->generateUrl("gallery_accommodation", array(
                                    'id'=>$accommodation->getId()
                )));
            }
        }
        return $this->render('BackAccommodationBundle::gallery.html.twig', array(
                    'form'         =>$form->createView(),
                    'accommodation'=>$accommodation
        ));
    }

    public function deletePhotoAction(Media $media)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $em->remove($media);
        $em->flush();
        $session->getFlashBag()->add('success', "Your photo has been deleted successfully");
        return $this->redirect($this->generateUrl("gallery_accommodation", array(
                            'id'=>$media->getAccommodation()->getId()
        )));
    }

    public function roomsAction(Accommodation $accommodation, $id2)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id2 == NULL)
            $room=new Room();
        else
            $room=$em->getRepository("BackAccommodationBundle:Room")->find($id2);
        $form=$this->createForm(new RoomType, $room);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $room=$form->getData();
                $room->setAccommodation($accommodation);
                $em->persist($room);
                $em->flush();
                $session->getFlashBag()->add('success', "Your room has been added successfully");
                return $this->redirect($this->generateUrl("room_big_accommdation", array( 'id'=>$accommodation->getId() )));
            }
        }
        return $this->render('BackAccommodationBundle::rooms.html.twig', array(
                    'form'         =>$form->createView(),
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
        return $this->redirect($this->generateUrl("room_big_accommdation", array( 'id'=>$room->getAccommodation()->getId() )));
    }

    public function prixAction(Accommodation $accommodation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $price=new Price();
        $form=$this
                ->createForm(new PriceType(), $price)
                ->add('room', "entity", array(
            'class'        =>'BackAccommodationBundle:Room',
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
                return $this->redirect($this->generateUrl("room_big_prix", array(
                                    'id'=>$accommodation->getId()
                )));
            }
        }
        return $this->render("BackAccommodationBundle::prices.html.twig", array(
                    'form'         =>$form->createView(),
                    'accommodation'=>$accommodation,
        ));
    }

    public function deletePrixAction(Price $price)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($price);
            $em->flush();
            $session->getFlashBag()->add('success', " Your price has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This room is used by another table ');
        }
        return $this->redirect($this->generateUrl("room_big_prix", array( 'id'=>$price->getRoom()->getAccommodation()->getId() )));
    }

    public function reviewsAction()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        $reviews=$em->getRepository("FrontGeneralBundle:Review")->findBy(array( 'validated'=>false ), array( 'id'=>'desc' ));
        return $this->render('BackAccommodationBundle::list_reviews.html.twig', array(
                    'reviews'=>$reviews
        ));
    }

    public function validateReviewAction(\Front\GeneralBundle\Entity\Review $review)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $accommodation=$review->getAccommodation();
        $count=0;
        $sum=0;
        foreach($accommodation->getAllReviews() as $rev)
        {
            if($rev->getValidated())
            {
                $count++;
                $sum+=$rev->getNote();
            }
        }
        $em->persist($review->setValidated(true));
        $em->persist($accommodation->setReviews(intval($count))->setNote((intval($sum / $count))));
        $em->flush();
        $session->getFlashBag()->add('success', "Your review has been validated successfully");
        return $this->redirect($this->generateUrl('backacco_list_reviews'));
    }

    public function deleteReviewAction(\Front\GeneralBundle\Entity\Review $review)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $em->remove($review);
        $em->flush();
        $session->getFlashBag()->add('success', "Your review has been deleted successfully");
        return $this->redirect($this->generateUrl('backacco_list_reviews'));
    }

}
