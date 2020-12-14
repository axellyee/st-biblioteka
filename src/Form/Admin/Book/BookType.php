<?php

namespace App\Form\Admin\Book;

use App\Entity\Book\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Virsraksts',
            ])
            ->add('description', null, [
                'label' => 'Apraksts',
            ])
            ->add('image', FileType::class, [
                'label' => 'Bilde',
                'data_class' => null,
                'required' => false,
                'mapped' => false,
            ])
            ->add('suubmit', SubmitType::class, [
                'label' => 'Saglabāt',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
