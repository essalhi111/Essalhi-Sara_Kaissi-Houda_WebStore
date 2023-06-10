<?php

namespace App\Form;

use Doctrine\ORM\Mapping\Entity;
use SebastianBergmann\Type\Type;
use App\Entity\Address;
use App\Controller\RegistrationController;
use App\Entity\Utilisateur;
use App\Entity\Transporter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder


            ->add('transporter', Entitytype::class, [
                'class' => Transporter::class,
                'label' => false,
                'required' => true,
                'multiple' => false,
                //'choices'=> $user->getAddresses()


            ])

            ->add('addresses', Entitytype::class, [
                'class' => Address::class,
                'label' => false,
                'required' => true,
                'multiple' => false,
               // 'choices'=> $utilisateur->getAddresses(),


            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           'user' => []
        ]);
    }
}
