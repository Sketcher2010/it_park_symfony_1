<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\ShopUser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Название книги',
                'attr' => [
                    'placeholder' => 'Моя книга 1'
                ]
            ])
            ->add('author', EntityType::class, [
                'label' => "Автор",
                'required' => true,
                'class' => ShopUser::class,
                'choice_label' => 'email'
            ])
            ->add('pages_count', IntegerType::class, [
                'required' => true,
                'label' => 'Количество страниц книги',
                'attr' => [
                    'placeholder' => '999'
                ]
            ])
            ->add('price', MoneyType::class, [
                'required' => true,
                'label' => 'Стоимость книги',
                'attr' => [
                    'placeholder' => '500'
                ]
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
