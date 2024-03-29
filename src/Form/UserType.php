<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Context\ExecutionContext;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void /* Création d'un type de formulaire */
    {
        $builder

            ->add("confirm", PasswordType::class, [
                "label" => "Confirmer le mot de passe",
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Le mot de passe ne peut pas être vide !"]),
                    new Callback([
                        'callback' => function ($value, ExecutionContext $ec) {
                            if ($ec->getRoot()['password']->getViewData() !== $value) {
                                $ec->addViolation("Les mots de passe doivent être identiques !");
                            }
                        }
                    ])
                ]
            ])

            ->add(
                "name", TextType::class,
                [
                    "label" => "Nom",
                    "required" => true,
                    'constraints'
                    => [
                        new NotBlank(['message' => "Veuillez renseigner votre nom"]),
                        new Regex(['pattern' => '/^[A-Z]{2,}/', 'message' => "Entrez votre nom en majuscule"]),
                        new Length(["min" => 3, "max" => 50, "minMessage" => "Le nom d'utilisateur doit etre compris entre 3 et 50 caracteres", "maxMessage" => "Le nom d'utilisateur ne doit pas faire plus de 50 caractères"])
                    ]
                ]
            )

            ->add(
                "firstname", TextType::class,
                [
                    "label" => "Prénom",
                    "required" => true,
                    'constraints'
                    => [
                        new NotBlank(['message' => "Veuillez renseigner votre prénom"]),
                        new Regex(['pattern' => '/^[A-Z][a-z]{2,}/', 'message' => "Entrez votre prénom en commençant par une majuscule"]),
                        new Length(["min" => 3, "max" => 50, "minMessage" => "Le nom d'utilisateur doit etre compris entre 3 et 50 caracteres", "maxMessage" => "Le nom d'utilisateur ne doit pas faire plus de 50 caractères"])
                    ]
                ]
            )



            ->add(
                "email", EmailType::class,
                [
                    "label" => "Adresse e-mail",
                    "required" => true,
                    "constraints" /*Ajout de contraites de validation grace au composant validator*/
                    => [
                        new Length(["min" => 2, "max" => 80, "minMessage" => "Le nom d'utilisateur doit etre compris entre 2 et 80 caracteres", "maxMessage" => "Le nom d'utilisateur ne doit pas faire plus de 80 caractères"]),
                        new NotBlank(['message' => "Le contenu ne doit pas etre vide et/ou doit contenir plus d'un caractere"])
                    ]
                ]
            )

            ->add(
                "phone", TextType::class,
                [
                    "label" => "Numéro de téléphone",
                    "required" => true,
                    'constraints'
                    => [
                        new NotBlank(['message' => "Veuillez renseigner votre numéro de téléphone"]),
                        new Length(["min" => 10, "max" => 10, "exactMessage" => "Le numéro de téléphone doit contenir 10 caractères '0XXXXXXXXX'"]),
                        new Regex(['pattern' => '/0[1-9]\d{8}/', 'message' => "Entrez un numéro de téléphone avec ce format '0XXXXXXXXX' sans tirets ni espaces"])
                    ]
                ]
            )

            ->add(
                "password", PasswordType::class,
                [
                    "label" => "Mot de passe",
                    "required" => true,
                    'constraints'
                    => [
                        new NotBlank(['message' => "Le mot de passe ne doit pas etre vide"]),
                        new Regex(['pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*]).{8,}$/',
                         'message' => 
                         "Le mot de passe doit contenir au moins 8 caractères dont un numéro, 
                         une majuscule et un caractère spécial (!,@,#,$,%,^,&,*)"])
                    ]
                ]
            )

            ->add('flatware', ChoiceType::class, [
                'choices' => [
                    '1 couvert' => 1,
                    '2 couverts' => 2,
                    '3 couverts' => 3,
                    '4 couverts' => 4,
                    '5 couverts' => 5,
                    '6 couverts' => 6,
                    '7 couverts' => 7,
                    '8 couverts' => 8,
                    '9 couverts' => 9,
                    '10 couverts' => 10
                ],
             
            ])

            ->add('allergy', ChoiceType::class, [
                'label' => "Type d'allergie",
                'choices' => [
                    'Gluten' => 'Gluten',
                    'Lactose' => 'Lactose',
                    'Arachide' => 'Arachide',
                    'Fruits de mer' => 'Fruits de mer',
                    'Oeuf' => 'Oeuf',
                ],
                'multiple' => true,
                'expanded' => true,
            ]);



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => User::class,
            'csrf_protection' => true,
            /* securise le formulaire*/
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'user_item',
        ]);
    }
}