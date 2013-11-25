<?php

namespace MUMECS\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MUMECSAPIBundle:Default:index.html.twig', array('name' => $name));
    }
}
