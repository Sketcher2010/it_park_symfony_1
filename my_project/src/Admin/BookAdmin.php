<?php

namespace App\Admin;

use App\Entity\ShopUser;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class BookAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', TextType::class);
        $formMapper->add('pagesCount', NumberType::class);
        $formMapper->add('price', NumberType::class);
        $formMapper->add('author', EntityType::class, [
            'class' => ShopUser::class,
            'choice_label' => 'email'
        ]);
        $formMapper->add('isDelete', CheckboxType::class, [
            'required' => false
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
        $datagridMapper->add('pagesCount');
        $datagridMapper->add('price');
        $datagridMapper->add('isDelete');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
        $listMapper->addIdentifier('pagesCount');
        $listMapper->addIdentifier('price');
        $listMapper->addIdentifier('isDelete');
    }
}