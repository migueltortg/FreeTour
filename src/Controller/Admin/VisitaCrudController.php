<?php

namespace App\Controller\Admin;

use App\Entity\Visita;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;



class VisitaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Visita::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Información'),
            TextField::new('nombre'),
            TextEditorField::new('descripcion'),
            ImageField::new('foto')
            ->setBasePath('fotos_visitas/') 
            ->setUploadDir('public/fotos_visitas/')
            ->setUploadedFileNamePattern('[uuid].[extension]'),
            FormField::addTab('Dirección'),
            TextField::new('GPS')
            ->setLabel("Coordenadas"),
            AssociationField::new('codLocalidad')
            ->setLabel("Localidad"),

        ];
    }
}
