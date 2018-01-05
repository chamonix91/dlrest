<?php
namespace DL\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('email', EmailType::class);
        $builder->add('plainPassword'); // Rajout du mot de passe
        $builder->add('password'); // Rajout du mot de passe
        $builder->add('nom');
        $builder->add('prenom');
        $builder->add('enabled', HiddenType::class, array(
            'data' => '1',
        ));
        $builder->add('roles', ChoiceType::class,
            array('label' => 'Type ', 'choices' =>
                array('FINANCE' => 'ROLE_FINANCE','WEBMASTER' => 'ROLE_WEBMASTER',),
                'required' => true, 'multiple' => true,));



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