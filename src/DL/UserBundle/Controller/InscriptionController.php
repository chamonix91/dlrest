<?php

namespace DL\UserBundle\Controller;

use DL\UserBundle\Entity\User;
use DL\UserBundle\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use Symfony\Component\HttpFoundation\Request;

class InscriptionController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**

     * @Rest\Post("/inscription")
     * @param Request $request
     * @return User|\Symfony\Component\Form\FormInterface
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function InscriptionAction(Request $request)
    {
        var_dump($request);
        die();
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['validation_groups'=>['Default', 'New']]);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $encoder = $this->get('security.password_encoder');
            // le mot de passe en claire est encodé avant la sauvegarde
            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);

            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }
}
