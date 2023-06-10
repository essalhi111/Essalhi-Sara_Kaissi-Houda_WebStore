<?php

namespace App\Controller\Admin;

use App\Entity\Transporter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TransporterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transporter::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new(propertyName:'id')->hideOnForm(),
            TextField::new(propertyName:'title'),
            TextareaField::new(propertyName:'content'),
            MoneyField::new(propertyName:'price')->setCurrency(currencyCode:'EUR'),
        ];
    }
}
