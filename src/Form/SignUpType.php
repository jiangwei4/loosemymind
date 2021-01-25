<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo', null, array('attr'=> array(
                'class'=> 'text-field-9 w-input',
                'data-name'=>'Ma photo',
                'placeholder'=>'' ,
                'required'=>false
            )))
            ->add('nom', null, array('attr'=> array(
                'class'=> 'text-field-9 w-input',
                'data-name'=>'Nom',
                'placeholder'=>'' ,
                'required'=>true
            )))
            ->add('prenom', null, array('attr'=> array(
                'class'=> 'text-field-9 w-input',
                'data-name'=>'Prénom',
                'placeholder'=>'' ,
                'required'=>true
            )))
            ->add('telephone', null, array('attr'=> array(
                'class'=> 'text-field-9 w-input',
                'data-name'=>'Mon numéro de telephone',
                //'id'=>'Mon-num-ro-de-telephone' ,
                'placeholder'=>'0612345678' ,
                'required'=>true
            )))
            ->add('mail', null, array('attr'=> array(
                'class'=> 'text-field-9 w-input',
                'data-name'=>'Mon email',
                'placeholder'=>'' ,
                'required'=>true
            )))
            ->add('password',RepeatedType::class,array(
                'type'=> PasswordType::class,
                'first_options'=>array('label'=>'mot de passe'),
                'second_options' => array('label'=>'Répéter le mot de passe'),
            ))
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
