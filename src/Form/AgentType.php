<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Country;
use App\Entity\Speciality;
use App\Repository\CountryRepository;
use App\Repository\SpecialityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('dateOfBirth', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
            ])
            ->add('code', TextType::class, [
                'label' => 'Nom de code'
            ])
            ->add('country', EntityType::class, [
                'placeholder' => "Quel est le pays d'origine ?",
                'class' => Country::class,
                'label' => 'Pays',
                'query_builder' => function (CountryRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name'
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
