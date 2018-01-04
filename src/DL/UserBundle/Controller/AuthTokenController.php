<?php

namespace DL\UserBundle\Controller;

use FOS\RestBundle\View\View;
use JMS\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use DL\UserBundle\Form\Type\CredentialsType;
use DL\UserBundle\Entity\AuthToken;
use DL\UserBundle\Entity\Credentials;


class AuthTokenController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"auth-token"})
     * @Rest\Post("/sign-in")
     * @param Request $request
     * @return AuthToken|\FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postAuthTokensAction(Request $request)
    {
        $credentials = new Credentials();
        $form = $this->createForm(CredentialsType::class, $credentials);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $user = $em->getRepository('DLUserBundle:User')
            ->findOneBy(array('email'=> $credentials->getLogin()));

        if (!$user) { // L'utilisateur n'existe pas
            return $this->invalidCredentials();
        }

        $encoder = $this->get('security.password_encoder');
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            return $this->invalidCredentials();
        }

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);

        $em->persist($authToken);
        $em->flush();
        $a=$authToken->getUser();

        return $a;


        //return array($authToken->getUser()->getId(),$authToken->getUser()->getEmail(),$authToken->getUser()->getPassword());
    }

    /**
     * @return \FOS\RestBundle\View\View
     */
    private function invalidCredentials()
    {
        $view = View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
        return $view;
    }


}
