<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\HidingPlace;
use App\Entity\Mission;
use App\Entity\TypeHidingPlace;
use App\Repository\CountryRepository;
use App\Repository\MissionRepository;
use App\Repository\TypeHidingPlaceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HidingPlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('country', EntityType::class, [
                'placeholder' => 'Pays',
                'class' => Country::class,
                'label' => 'Pays',
                'query_builder' => function (CountryRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
            ->add('type', EntityType::class, [
                'placeholder' => 'Type de planque',
                'class' => TypeHidingPlace::class,
                'label' => 'Type de planque',
                'query_builder' => function (TypeHidingPlaceRepository $tr) {
                    return $tr->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HidingPlace::class,
        ]);
    }
}
