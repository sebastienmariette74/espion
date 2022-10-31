<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\HidingPlace;
use App\Entity\Mission;
use App\Entity\Speciality;
use App\Entity\StatusMission;
use App\Entity\Target;
use App\Entity\TypeMission;
use App\Repository\AgentRepository;
use App\Repository\ContactRepository;
use App\Repository\CountryRepository;
use App\Repository\HidingPlaceRepository;
use App\Repository\SpecialityRepository;
use App\Repository\StatusMissionRepository;
use App\Repository\TargetRepository;
use App\Repository\TypeMissionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class MissionType extends AbstractType
{
    public function __construct(private AgentRepository $agentRepo)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', CKEditorType::class, [
                'config_name' => 'my_config',
                'label' => 'Description',
                'constraints' => new NotBlank(['message' => 'Veuillez entrer une description.']),

            ])
            ->add('codeName', TextType::class, [
                'label' => 'Code',
                // 'required' => true,
                'constraints' => new NotBlank(['message' => 'Veuillez entrer un nom de code.']),
            ])
            ->add('begin_at', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'input'  => 'datetime_immutable',
                'data' => new \DateTimeImmutable()
            ])
            ->add('finish_at', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'required' => false,
                'input'  => 'datetime_immutable',
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
            ->add('type', EntityType::class, [
                'placeholder' => 'Type',
                'class' => TypeMission::class,
                'label' => 'Type',
                "required" => false,
                'query_builder' => function (TypeMissionRepository $tr) {
                    return $tr->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
            ->add('status', EntityType::class, [
                'placeholder' => 'Statut',
                'class' => StatusMission::class,
                'label' => 'Statut',
                'query_builder' => function (StatusMissionRepository $sr) {
                    return $sr->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
            ->add('speciality', EntityType::class, [
                'placeholder' => 'Spécialité',
                'help' => 'Au moins 1 agent doit détenir la spécialité choisie.',
                'class' => Speciality::class,
                'label' => 'Spécialité',
                'required' => true,
                'query_builder' => function (SpecialityRepository $sr) {
                    return $sr->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
            ->add('hidingPlace', EntityType::class, [
                'class' => HidingPlace::class,
                'label' => 'Planque(s)',
                'multiple' => true,
                "required" => false,
                'query_builder' => function (HidingPlaceRepository $hr) {
                    return $hr->createQueryBuilder('h')
                        ->orderBy('h.code', 'ASC');
                },
                'choice_label' => function (HidingPlace $hidingPlace) {
                    // return $hidingPlace->getCode();
                    return $hidingPlace->getCode() . ' (' . $hidingPlace->getCountry() . ')';
                },
            ])
            ->add('agent', EntityType::class, [
                'placeholder' => 'Agent(s)',
                'class' => Agent::class,
                'label' => 'Agent(s)',

                'multiple' => true,
                "required" => false,
                'query_builder' => function (AgentRepository $ar) {
                    return $ar->createQueryBuilder('a')
                        ->orderBy('a.firstname', 'ASC');
                },
                // 'choice_label' => function (Agent $agent) {
                //     return $agent->getCode();
                // },
                'choice_label' => function (Agent $agent) {
                    $specialities = $agent->getSpeciality();
                    $tab = [];
                    foreach ($specialities as $speciality) {
                        $tab[] = $speciality->getName();
                    }
                    $string = implode(' - ', $tab);
                    return $agent->getCode() . ' => ' . $string . ' (' . $agent->getCountry() . ')';
                },
            ])
            ->add('target', EntityType::class, [
                'placeholder' => 'Cible(s)',
                'class' => Target::class,
                'label' => 'Cible(s)',

                'multiple' => true,
                "required" => false,
                'query_builder' => function (TargetRepository $tr) {
                    return $tr->createQueryBuilder('t')
                        ->orderBy('t.code', 'ASC');
                },
                'choice_label' => function (Target $target) {
                    return $target->getCode() . ' (' . $target->getCountry() . ')';
                },
            ])
            ->add('contact', EntityType::class, [
                'placeholder' => 'Contact(s)',
                'class' => Contact::class,
                'label' => 'Contact(s)',
                'multiple' => true,
                'required' => true,
                'query_builder' => function (ContactRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->orderBy('c.code', 'ASC');
                },
                'choice_label' => function (Contact $contact) {
                    return $contact->getCode() . ' (' . $contact->getCountry() . ')';
                },
            ]);


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                $contacts = $data->getContact();

                $form->add('contact', EntityType::class, [
                        'placeholder' => 'Contact(s)',
                        'class' => Contact::class,
                        'label' => 'Contact(s)',
                        'multiple' => true,
                        "required" => true,
                        'choices' => $contacts,
                        'query_builder' => function (ContactRepository $cr) {
                            return $cr->createQueryBuilder('c')
                                ->orderBy('c.code', 'ASC');
                        },
                        'choice_label' => function (Contact $contact) {
                            return $contact->getCode() . ' (' . $contact->getCountry() . ')';
                        }
                    ])
                ;
            }
        );       

        $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getForm()->getData();
                $form = $event->getForm()->getParent();
                $hidingPlaces = null === $data ? [] : $data->getHidingPlaces();
                $contacts = null === $data ? [] : $data->getContacts();
                $form->add('type', EntityType::class, [
                    'placeholder' => 'Type',
                    'class' => TypeMission::class,
                    'label' => 'Type',
                    "required" => false,
                    'query_builder' => function (TypeMissionRepository $tr) {
                        return $tr->createQueryBuilder('t')
                            ->orderBy('t.name', 'ASC');
                    },
                    'choice_label' => 'name'
                ]);

                $form->add('hidingPlace', EntityType::class, [
                    'class' => HidingPlace::class,
                    'label' => 'Planque(s)',
                    'multiple' => true,
                    "required" => false,
                    'choices' => $hidingPlaces,
                    'choice_label' => function (HidingPlace $hidingPlace) {
                        return $hidingPlace->getCode();
                        // return $hidingPlace->getCode() . ' (' . $hidingPlace->getCountry() . ')';
                    },
                ])
                    ->add('contact', EntityType::class, [
                        'placeholder' => 'Contact(s)',
                        'class' => Contact::class,
                        'label' => 'Contact(s)',
                        'multiple' => true,
                        "required" => true,
                        'choices' => $contacts,
                        'query_builder' => function (ContactRepository $cr) {
                            return $cr->createQueryBuilder('c')
                                ->orderBy('c.code', 'ASC');
                        },
                        'choice_label' => function (Contact $contact) {
                            return $contact->getCode() . ' (' . $contact->getCountry() . ')';
                        },
                    ]);
            }
        );

        $builder->get('target')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getForm()->getData();
                $form = $event->getForm()->getParent();

                $countries = [];
                foreach ($data as $x) {
                    $countries[] = $x->getCountry()->getName();
                }
                $agents = $data === null ? [] : $this->agentRepo->findAllByCountries($countries);

                $form->add('agent', EntityType::class, [
                    'placeholder' => 'Agents(s)',
                    'class' => Agent::class,
                    'label' => 'Agents(s)',
                    'multiple' => true,
                    'choices' => $agents,
                    'query_builder' => function (AgentRepository $ar,) {
                        return $ar->createQueryBuilder('a')
                            ->orderBy('a.code', 'ASC');
                    },
                    'choice_label' => function (Agent $agent) {
                        $specialities = $agent->getSpeciality();
                        $tab = [];
                        foreach ($specialities as $speciality) {
                            $tab[] = $speciality->getName();
                        }
                        $string = implode(' - ', $tab);
                        return $agent->getCode() . ' => ' . $string . ' (' . $agent->getCountry() . ')';
                    },
                ]);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
