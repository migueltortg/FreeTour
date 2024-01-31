<?php

namespace App\Controller\Admin;

use App\Entity\Tour;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Doctrine\ORM\QueryBuilder;



class TourCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tour::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('fecha_hora')
            ->setLabel("Fecha y Hora"),
            AssociationField::new('codRuta')
            ->setLabel("Ruta"),
            AssociationField::new('guia')
            ->setLabel("Guia")
            ->setQueryBuilder(function (QueryBuilder $qb) {
                $qb->andWhere("entity.roles like :role")
                ->setParameter('role', "%ROLE_GUIDE%");
            }),

        ];
    }
}