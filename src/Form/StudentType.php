<?php

namespace App\Form;

use App\Entity\Classeroom;
use App\Entity\Club;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('name')
            ->add('classrooms',EntityType::class,[
                'class'=>Classeroom::class,
                'choice_label'=>'id'
            ])
            ->add('clubs',EntityType::class,[
                'class'=>Club::class,
                'choice_label'=>'id',
                'expanded' => true,
                'multiple' => true
            ]
            )
            ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
