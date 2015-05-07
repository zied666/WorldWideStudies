<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontGeneralBundle::accueil.html.twig');
    }
    public function index1Action()
    {
        return $this->render('FrontGeneralBundle::accueil1.html.twig');
    }
    public function index2Action()
    {
        return $this->render('FrontGeneralBundle::accueil2.html.twig');
    }
}
