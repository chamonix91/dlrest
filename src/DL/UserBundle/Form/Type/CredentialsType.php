<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 29/12/2017
 * Time: 14:58
 */

namespace DL\UserBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CredentialsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login');
        $builder->add('password');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'DL\UserBundle\Entity\Credentials',
            'csrf_protection' => false
        ]);
    }

}