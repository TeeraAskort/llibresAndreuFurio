<?php

namespace App\Controller\Admin;

use App\Entity\Usuari;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

class UsuariCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Usuari::class;
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
            IdField::new('id')->hideOnForm(), //ocult en la creació
            TextField::new('username'),
            TextField::new('password'),
            ArrayField::new('roles')->hideOnForm() //ocult en la creació
        ];
    }
}
