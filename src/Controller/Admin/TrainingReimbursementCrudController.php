<?php

namespace App\Controller\Admin;

use App\Entity\TrainingReimbursement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Routing\Attribute\Route;
use Vich\UploaderBundle\Form\Type\VichFileType;

#[Route('/admin/training-reimbursement')]
class TrainingReimbursementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TrainingReimbursement::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Dossier de remboursement')
            ->setEntityLabelInPlural('Dossiers de remboursement')
            ->setSearchFields(['id', 'trainee', 'traineeEmail', 'licenseNumber', 'amount', 'activity'])
            ->setPageTitle(
                'detail',
                fn (TrainingReimbursement $trainingReimbursement) => (string)$trainingReimbursement,
            )
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add('index', 'detail');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(ChoiceFilter::new('status')->setChoices([
            'Brouillon'              => 'draft',
            'Complet'                => 'complete',
            'Approuvé'               => 'approved',
            'En cours de traitement' => 'processing',
            'Terminé'                => 'finished',
        ]));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('trainee'),
            TextField::new('traineeEmail'),
            TextField::new('licenseNumber'),
            MoneyField::new('amount')->setCurrency('EUR'),
            ChoiceField::new('activity')->setChoices([
                'Snowboard'        => 'Snowboard',
                'Ski de randonnée' => 'Ski de randonnée',
            ]),
            TextField::new('status')->hideOnForm(),
            TextField::new('trainingCompletionCertificateFile')->setFormType(VichFileType::class)->hideOnIndex(),
            TextField::new('trainingExpensesFile')->setFormType(VichFileType::class)->hideOnIndex(),
            TextField::new('mileageExpensesFile')->setFormType(VichFileType::class)->hideOnIndex(),
            TextField::new('paymentDetailsFile')->setFormType(VichFileType::class)->hideOnIndex(),
        ];
    }
}
