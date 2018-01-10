<?php

namespace App\Form;

use App\Entity\Subject;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'admin' => 'ROLE_ADMIN',
                    'teacher' => 'ROLE_TEACHER',
                    'student' => 'ROLE_USER',
                )
            ))
        ;

        if ($options['isStudent']){
            $builder->add('learnedSubjects', EntityType::class, array(
                'class'    => Subject::class,
                'multiple' => true,
                'required' => false,
            ));//todo
        }elseif ($options['isTeacher']){
            $builder->add('taughtSubjects', EntityType::class, array(
                'class'    => Subject::class,
                'multiple' => true,
                'required' => false,
            ));//todo
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => User::class,
            'isStudent'  => false,
            'isTeacher'  => false,
        ]);
    }
}
