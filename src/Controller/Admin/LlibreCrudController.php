<?php

namespace App\Controller\Admin;

use App\Entity\Llibre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class LlibreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Llibre::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('isbn'),
            TextField::new('titol'),
            TextField::new('autor'),
            IntegerField::new('pagines'),
            ImageField::new('imatge')
                ->setBasePath('img/') //nom de la carpeta de les imatges
                ->setUploadDir('public/imgs')
                ->setRequired(false),
            AssociationField::new('editorial'),
        ];
    }
}
