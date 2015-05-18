<?php

namespace Front\GeneralBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;

class InterfacesExtension extends \Twig_Extension
{

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em=$em;
    }

    public function getFunctions()
    {
        return array(
            'getNameCity'=>new \Twig_Function_Method($this, 'getNameCity'),
            'getPhotoCity' => new \Twig_Function_Method($this, 'getPhotoCity'),
        );
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
