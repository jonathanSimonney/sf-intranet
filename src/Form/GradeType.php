<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', NumberType::class)
            ->add('comment', null, array('attr'=> array('class'=>'materialize-textarea')));
        if ($options['isAdmin']){
            $builder->add('owner', EntityType::class, array(
                'class'         => User::class,
                'placeholder'   => 'Select a student',
                'choices'       => $options['students']
            ));
        }else{
            $builder
                ->add('owner', EntityType::class, array(
                    'class'         => User::class,
                    'choices'       => $options['students'],
                    'placeholder'   => 'Select a student'
            ));
        }


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Grade::class,
            'isAdmin'    => false,
            'students'   => null,
        ]);
    }
}
