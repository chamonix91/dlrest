<?php
namespace DL\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', EmailType::class);
        $builder->add('email', EmailType::class);
        $builder->add('plainPassword'); // Rajout du mot de passe
        $builder->add('nom');
        $builder->add('prenom');
        $builder->add('enabled');



    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DL\UserBundle\Entity\User',
            'is_edit' => false,
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dl_userbundle_user';
    }


    // ...
}