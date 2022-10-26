<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\Nationality;
use App\Repository\CountryRepository;
use App\Repository\NationalityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
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
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'input'  => 'datetime_immutable',

            ])
            ->add('code', TextType::class, [
                'label' => 'Nom de code'
            ])            
            ->add('country', EntityType::class, [
                'placeholder' => 'Pays',
                'class' => Country::class,
                'label' => 'Pays',
                "required" => false,
                'query_builder' => function (CountryRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
