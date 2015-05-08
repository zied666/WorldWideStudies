<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class LanguageCoursesController extends Controller
{

    public function listAction()
    {
        return $this->render('FrontGeneralBundle:LanguageCourses:list.html.twig');
    }
}
