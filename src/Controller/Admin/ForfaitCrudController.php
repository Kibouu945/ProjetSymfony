<?php

namespace App\Controller\Admin;

use App\Entity\Forfait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ForfaitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Forfait::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom du forfait')->setRequired(true),
            MoneyField::new('prix', 'Prix du forfait')->setCurrency('EUR'),
            ArrayField::new('avantages', "Les avantages du forfait")->setHelp("Ces avantages seront listés pour le client. Ex: Boisson à volonté")->onlyOnForms()
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Forfait')
            ->setEntityLabelInPlural('Forfaits')
            ->setPageTitle('index', 'Les %entity_label_plural%')
            ->setPageTitle('new', 'Ajouter un nouveau %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier le %entity_label_singular%')
            ->setSearchFields(['name'])
            ->setDefaultSort(['prix' => 'DESC'])
            ->setPaginatorPageSize(15)
//            ->setEntityPermission('ROLE_ADMIN')
            ->setAutofocusSearch(true)
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, fn (Action $action) => $action->setIcon('fa fa-pencil-alt')->setLabel(false))
            ->update(Crud::PAGE_INDEX, Action::DELETE, fn (Action $action) => $action->setIcon('fa fa-trash')->setLabel(false));
    }
}
