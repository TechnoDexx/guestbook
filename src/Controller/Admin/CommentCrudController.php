<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
/*         return [
        IdField::new('id')->onlyOnIndex(),
        Field::new('author'),
        TextareaField::new('text'),
        EmailField::new('email'),
        DateTimeField::new('createdAt'),
        AssociationField::new('conference'),
]; */
yield AssociationField::new('conference');
yield TextField::new('author');
yield EmailField::new('email');
yield TextareaField::new('text')
    ->hideOnIndex()
;
yield TextField::new('photoFilename')
    ->onlyOnIndex()
;

$createdAt = DateTimeField::new('createdAt')->setFormTypeOptions([
    'years' => range(date('Y'), date('Y') + 5),
    'widget' => 'single_text',
]);
if (Crud::PAGE_EDIT === $pageName) {
    yield $createdAt->setFormTypeOption('disabled', true);
} else {
    yield $createdAt;
}

}

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Conference Comment')
            ->setEntityLabelInPlural('Conference Comments')
            ->setSearchFields(['author', 'text', 'email'])
            ->setDefaultSort(['createdAt' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('conference'))
        ;
    }

}