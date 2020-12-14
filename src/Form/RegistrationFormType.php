<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', null, [
                'label' => 'Vārds Uzvārds',
            ])
            ->add('email', null, [
                'label' => 'E-pasts',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Tev jāpiekrīt noteikumiem!',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Parole'],
                'second_options' => ['label' => 'Parole atkārtoti'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Lūdzu ievadi paroli',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Parolei jābūt vismaz {{ limit }} rakstzīmju garuumā',
                        'max' => 4096,
                    ]),
                ],
            ])
//            ->add('plainPassword', PasswordType::class, [
//                'mapped' => false,
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Lūūdzu ievadi paroli',
//                    ]),
//                    new Length([
//                        'min' => 6,
//                        'minMessage' => 'Parolei jābūt vismaz {{ limit }} rakstzīmju garuumā',
//                        'max' => 4096,
//                    ]),
//                ],
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
