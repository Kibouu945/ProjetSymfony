<?php

namespace App\Controller\Admin;

use App\Entity\CoffeeShop;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CoffeeShopCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CoffeeShop::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom du coffee shop')->setRequired(true),
            IntegerField::new('nombre_place_salle_prive_dispo', 'Salon Privé : Nombre de place minimum')->setRequired(true),
            IntegerField::new('nb_place_salle_prive_max_dispo', 'Salon Privé : Nombre de place maximum')->setRequired(true),
            IntegerField::new('nombre_place_indiv', 'Nombre de places individuelles')->setRequired(true),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Coffee Shop')
            ->setEntityLabelInPlural('Coffee Shops')
            ->setPageTitle('index', 'Les %entity_label_plural%')
            ->setPageTitle('new', 'Ajouter un nouveau %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier le %entity_label_singular%')
            ->setSearchFields(['name'])
            ->setPaginatorPageSize(15)
//            ->setEntityPermission('ROLE_ADMIN')
            ->setAutofocusSearch(true)
            ->showEntityActionsInlined();
    }
}
