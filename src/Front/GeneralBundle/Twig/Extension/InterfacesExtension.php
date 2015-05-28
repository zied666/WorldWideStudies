<?php

namespace Front\GeneralBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class InterfacesExtension extends \Twig_Extension
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
            'getNameCity'    =>new \Twig_Function_Method($this, 'getNameCity'),
            'getPhotoCity'   =>new \Twig_Function_Method($this, 'getPhotoCity'),
            'convertCurrency'=>new \Twig_Function_Method($this, 'convertCurrency'),
        );
    }

    function convertCurrency($amount, $from)
    {
        $session=$this->session->get('currency');
        if($from == $session['code'])
            return number_format($amount, $session['scale'], '.', '').' '.$from;
        $url="https://www.google.com/finance/converter?a=$amount&from=$from&to=".$session['code'];
        $data=file_get_contents($url);
        preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
        if(isset($converted[1]))
        {
            $converted=preg_replace("/[^0-9.]/", "", $converted[1]);
            return number_format($converted, $session['scale'], '.', '').' '.$session['code'];
        }
        return '';
    }

    public function getNameCity($id)
    {
        $city=$this->em->getRepository("BackReferentielBundle:City")->find($id);
        return $city->getLibelle();
    }

    public function getPhotoCity($id)
    {
        $city=$this->em->getRepository("BackReferentielBundle:City")->find($id);
        return $city->getImage()->getAssetPath();
    }

    public function getName()
    {
        return 'InterfaceExtensions';
    }

}
