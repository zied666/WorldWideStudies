<?php

namespace Back\SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\SchoolBundle\Entity\SchoolLocation;
use Back\SchoolBundle\Form\SchoolLocationType;
use Back\ReferentielBundle\Entity\Media;
use Back\ReferentielBundle\Form\MediaType;

class SchoolController extends Controller
{

    public function cloneSchoolAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $newSchoolLocation=clone $schoolLocation;
        $em->persist($newSchoolLocation);
        foreach($schoolLocation->getCourses() as $entity)
        {
            $newCourse=clone $entity;
            $em->persist($newCourse->setSchoolLocation($newSchoolLocation));
            foreach($entity->getStartDates() as $ent)
            {
                $newEnt=clone $ent;
                $em->persist($newEnt->setCourse($newCourse));
            }
            foreach($entity->getPrices() as $ent)
            {
                $newEnt=clone $ent;
                $em->persist($newEnt->setCourse($newCourse));
            }
            foreach($entity->getPathwayPrices() as $ent)
            {
                $newEnt=clone $ent;
                $em->persist($newEnt->setCourse($newCourse));
            }
            foreach($entity->getCourseSubjects() as $ent)
            {
                $newCourseSubject=clone $ent;
                $em->persist($newCourseSubject->setCourse($newCourse));
                foreach($ent->getDescriptions() as $entt)
                {
                    $newEnt=clone $entt;
                    $em->persist($newEnt->setCourseSubject($newCourseSubject));
                }
            }
        }
        foreach($schoolLocation->getPhotos() as $entity)
        {
            $newEntity=clone $entity;
            $em->persist($newEntity->setSchoolLocation($newSchoolLocation));
        }
        foreach($schoolLocation->getAccommodations() as $entity)
        {
            $newAccommodation=clone $entity;
            $em->persist($newAccommodation->setSchoolLocation($newSchoolLocation));
            foreach($entity->getRooms() as $room)
            {
                $newRoom=clone $room;
                $em->persist($newRoom->setAccommodation($newAccommodation));
                foreach($room->getPrices() as $ent)
                {
                    $newEnt=clone $ent;
                    $em->persist($newEnt->setRoom($newRoom));
                }
                foreach($room->getPathwayPrices() as $ent)
                {
                    $newEnt=clone $ent;
                    $em->persist($newEnt->setRoom($newRoom));
                }
            }
        }
        foreach($schoolLocation->getExtras() as $entity)
        {
            $newEntity=clone $entity;
            $em->persist($newEntity->setSchoolLocation($newSchoolLocation));
        }
        $em->flush();
        $session->getFlashBag()->add('success', "Your School location has been cloned successfully");
        if($schoolLocation->getType() == 1)
            return $this->redirect($this->generateUrl("list_schoolLanguage"));
        else
            return $this->redirect($this->generateUrl("list_schoolPathway"));
    }

    public function addSchoolAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $schoolLocation=new SchoolLocation();
        $form=$this->createForm(new SchoolLocationType(), $schoolLocation);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $schoolLocation=$form->getData();
                $em->persist($schoolLocation->setEnabled(TRUE));
                $em->flush();
                $session->getFlashBag()->add('success', "Your school has been added successfully");
                return $this->redirect($this->generateUrl("add_school"));
            }
        }
        return $this->render('BackSchoolBundle:school:add.html.twig', array(
                    'form'=>$form->createView(),
        ));
    }

    public function editSchoolAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $form=$this->createForm(new SchoolLocationType(), $schoolLocation);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $schoolLocation=$form->getData();
                $em->persist($schoolLocation->setEnabled(TRUE));
                $em->flush();
                $session->getFlashBag()->add('success', "Your school has been added successfully");
                return $this->redirect($this->generateUrl("edit_school", array( 'id'=>$schoolLocation->getId() )));
            }
        }
        return $this->render('BackSchoolBundle:school:edit.html.twig', array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation
        ));
    }

    public function listSchoolLanguageAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $session=$this->getRequest()->getSession();
        $query=$em->getRepository("BackSchoolBundle:SchoolLocation")->findBy(array( 'type'=>1 ), array( 'id'=>'desc' ));
        $paginator=$this->get('knp_paginator');
        $schoolLocations=$paginator->paginate($query, $request->query->get('page', 1), 10);
        return $this->render('BackSchoolBundle:school:list.html.twig', array(
                    'schools'=>$schoolLocations
        ));
    }

    public function listSchoolPathwayAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $session=$this->getRequest()->getSession();
        $query=$em->getRepository("BackSchoolBundle:SchoolLocation")->findBy(array( 'type'=>2 ), array( 'id'=>'desc' ));
        $paginator=$this->get('knp_paginator');
        $schoolLocations=$paginator->paginate($query, $request->query->get('page', 1), 10);
        return $this->render('BackSchoolBundle:school:list.html.twig', array(
                    'schools'=>$schoolLocations
        ));
    }

    public function deleteSchoolAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();

        try
        {
            $em->remove($schoolLocation);
            $em->flush();
            $session->getFlashBag()->add('success', " Your school has been successfully removed ");
        }
        catch(\Exception $ex)
        {
//            $session->getFlashBag()->add('danger', 'This school is used by another table ');
            $session->getFlashBag()->add('danger', $ex->getMessage());
        }
        if($schoolLocation->getType() == 1)
            return $this->redirect($this->generateUrl("list_schoolLanguage"));
        else
            return $this->redirect($this->generateUrl("list_schoolPathway"));
    }

    public function enableSchoolAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($schoolLocation->isEnabled())
            $schoolLocation->setEnabled(FALSE);
        else
            $schoolLocation->setEnabled(TRUE);
        $em->persist($schoolLocation);
        $em->flush();
        $session->getFlashBag()->add('success', "Your school has been updates successfully");
        if($schoolLocation->getType() == 1)
            return $this->redirect($this->generateUrl("list_schoolLanguage"));
        else
            return $this->redirect($this->generateUrl("list_schoolPathway"));
    }

    public function homepageSchoolAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($schoolLocation->getHomepage())
            $schoolLocation->setHomepage(FALSE);
        else
            $schoolLocation->setHomepage(TRUE);
        $em->persist($schoolLocation);
        $em->flush();
        $session->getFlashBag()->add('success', "Your school has been updates successfully");
        if($schoolLocation->getType() == 1)
            return $this->redirect($this->generateUrl("list_schoolLanguage"));
        else
            return $this->redirect($this->generateUrl("list_schoolPathway"));
    }

    public function galleryAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $media=new Media();
        $media->setSchoolLocation($schoolLocation);
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
                return $this->redirect($this->generateUrl("gallery_school", array(
                                    'id'=>$schoolLocation->getId()
                )));
            }
        }
        return $this->render('BackSchoolBundle:school:gallery.html.twig', array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation
        ));
    }

    public function deletePhotoAction(Media $media)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $em->remove($media);
        $em->flush();
        $session->getFlashBag()->add('success', "Your photo has been deleted successfully");
        return $this->redirect($this->generateUrl("gallery_school", array(
                            'id'=>$media->getSchoolLocation()->getId()
        )));
    }

    public function reviewsAction()
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        $reviews=$em->getRepository("FrontGeneralBundle:Review")->findBy(array( 'validated'=>false ), array( 'id'=>'desc' ));
        return $this->render('BackSchoolBundle:school:list_reviews.html.twig', array(
                    'reviews'=>$reviews
        ));
    }

    public function validateReviewAction(\Front\GeneralBundle\Entity\Review $review)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $school= $review->getSchoolLocation();
        $em->persist($review->setValidated(true));
        $count=0;
        $sum=0;
        foreach($school->getAllReviews() as $rev)
        {
            if($rev->getValidated())
            {
                $count++;
                $sum+=$rev->getNote();
            }
        }
        $em->persist($school->setReviews(intval($count))->setStars(intval($sum/$count))->setNote((intval($sum/$count))));
        $em->flush();
        $session->getFlashBag()->add('success', "Your review has been validated successfully");
        return $this->redirect($this->generateUrl('back_list_reviews'));
    }

    public function deleteReviewAction(\Front\GeneralBundle\Entity\Review $review)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $em->remove($review);
        $em->flush();
        $session->getFlashBag()->add('success', "Your review has been deleted successfully");
        return $this->redirect($this->generateUrl('back_list_reviews'));
    }

}
