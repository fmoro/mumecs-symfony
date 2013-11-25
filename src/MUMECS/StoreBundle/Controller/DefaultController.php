<?php

namespace MUMECS\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MUMECS\StoreBundle\Document\User;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    public function indexAction() {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $users = $dm->getRepository('MUMECSStoreBundle:User')->findAll();
        
        echo ("<pre>");
        print_r($users);
        die("</pre>");
        
        return $this->render('MUMECSStoreBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function createAction() {
        
        $user = new User();
        $user->setEmail('drzayer@gmail.com')
                ->setName('Federico')
                ->setSurname('Moro del Álamo')
                ->setRegion('Valencia')
                ->setPassword('lala');
        
        $encoder = $this->get('security.encoder_factory')
                ->getEncoder($user);
        
        $user->setSalt(md5(time()));
        $passwordCodificado = $encoder->encodePassword(
            $user->getPassword(),
            $user->getSalt()
        );
        $user->setPassword($passwordCodificado);

        //die('no he metido el usuario');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($user);
        $dm->flush();
        //die('flush hecho');
        return new Response('Created product id '.$user->getId());
    }
}
