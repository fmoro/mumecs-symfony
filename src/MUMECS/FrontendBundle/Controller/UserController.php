<?php

/*
 * The MIT License
 *
 * Copyright 2013 darkstar.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace MUMECS\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use MUMECS\FrontendBundle\Form\Type\RegistrationType;
use MUMECS\FrontendBundle\Form\Model\Registration;

/**
 * Description of UserController
 *
 * @author darkstar
 */
class UserController extends Controller {
    public function loginAction(Request $request) {
        $session = $request->getSession();

        $error = $request->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $session->get(Securitycontext::AUTHENTICATION_ERROR)
        );

        return $this->render('MUMECSFrontendBundle:User:login.html.twig', array(
            'username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
            'form' => $this->createUserForm()->createView()
        ));
    }
    
    public function indexAction() {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $entities = $dm->getRepository('MUMECSStoreBundle:User')->findAll();
        
        return $this->render('MUMECSFrontendBundle:User:index.html.twig', array(
            'entities' => $entities
        ));
    }
    
    public function newAction() {
        $form = $this->createForm(new RegistrationType(), new Registration());

        return $this->render('MUMECSFrontendBundle:User:new.html.twig', array('form' => $form->createView()));
    }
    
    public function createAction() {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $registration = $form->getData();

            $user = $registration->getUser();
            
            $encoder = $this->get('security.encoder_factory')
                ->getEncoder($user);
        
            $user->setSalt(md5(time()));
            $passwordCodificado = $encoder->encodePassword(
                $user->getPassword(),
                $user->getSalt()
            );
            $user->setPassword($passwordCodificado);
            
            $dm->persist($user);
            $dm->flush();

            return $this->redirect($this->generateUrl('mumecs_frontend_user_show', array('id' => $registration->getUser()->getId())));
        }

        return $this->render('MUMECSFrontendBundle:User:new.html.twig', array('form' => $form->createView()));
    }
    
    public function showAction($id) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        
        $entity = $dm->getRepository('MUMECSStoreBundle:User')->find($id);
        
        if (!$entity)
            throw $this->createNotFoundException('Unable to find User entity.');
        
        return $this->render('MUMECSFrontendBundle:User:show.html.twig', array('entity' => $entity));
    }
}
