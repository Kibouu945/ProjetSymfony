<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{

	public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
	{
	}

	public static function getEntityFqcn(): string
	{
		return User::class;
	}


	public function configureFields(string $pageName): iterable
	{
		return [
			EmailField::new('email', "Email")->setRequired(true),
			TextField::new('Lastname', 'Nom')->setRequired(true),
			TextField::new('Firstname', 'Prénoms')->setRequired(true),
			TextField::new('Adress', 'Adresse'),
			TextField::new('password')->onlyOnForms(),
			ChoiceField::new('roles')->allowMultipleChoices()->setChoices([
				'Admin' => 'ROLE_ADMIN',
				'User' => 'ROLE_USER',
			]),
		];
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInSingular('Utilisateur')
			->setEntityLabelInPlural('Utilisateurs')
			->setPageTitle('index', 'Les %entity_label_plural%')
			->setPageTitle('detail', fn(User $user) => (string)$user)
			->setPageTitle('edit', fn(User $user) => sprintf('Editing <b>%s</b>', $user))
		;
	}

	public function createEntity(string $entityFqcn): User
	{
		$user = new User();
		$user->setRoles(['ROLE_USER']);
		return $user;
	}

	public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
	{
		$entityInstance->setPassword($this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword()));
		parent::persistEntity($entityManager, $entityInstance);
	}

	public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
	{
		$entityInstance->setPassword($this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword()));
		parent::updateEntity($entityManager, $entityInstance);
	}
}
