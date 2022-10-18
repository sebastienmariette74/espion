<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Nationality;
use App\Entity\Speciality;
use App\Repository\NationalityRepository;
use App\Repository\SpecialityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Prénom'
            ])
            // ->add('dateOfBirth', DateType::class)
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'input'  => 'datetime_immutable',
                // 'format' => 'yyy-MM-dd'

            ])
            ->add('code', TextType::class, [
                'label' => 'Nom de code'
            ])
            ->add('nationality', EntityType::class, [
                'placeholder' => 'Quelle est la nationalité ?',
                'class' => Nationality::class,
                'label' => 'Nationalité',
                'query_builder' => function (NationalityRepository $nr) {
                    return $nr->createQueryBuilder('n')
                        ->orderBy('n.nationality', 'ASC');
                },
                'choice_label' => 'nationality'

            ])
            ->add('speciality', EntityType::class, [
                'label' => 'Spécialité',
                'expanded' => false,
                'class' => Speciality::class,
                'multiple' => true,
                'query_builder' => function (SpecialityRepository $sr) {
                    return $sr->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
            // ->add('missions', CollectionType::class, [
            //     'label' => 'Prénom'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
