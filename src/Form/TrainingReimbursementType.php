<?php

namespace App\Form;

use App\Entity\TrainingReimbursement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class TrainingReimbursementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('trainee', null, ['label' => 'Nom'])
            ->add('traineeEmail', null, ['label' => 'Email'])
            ->add('licenseNumber', null, ['label' => 'Numéro de license'])
            ->add(
                'amount',
                MoneyType::class,
                ['label' => 'Montant des frais de formation (€)', 'currency' => 'EUR', 'divisor' => 100],
            )
            ->add('activity', ChoiceType::class, [
                'label' => 'Activité',
                'choices' => [
                    'Snowboard' => 'Snowboard',
                    'Ski de randonnée' => 'Ski de randonnée',
                ],
            ])
            ->add(
                'trainingCompletionCertificateFile',
                VichFileType::class,
                ['required' => false, 'label' => 'Certificat de fin de formation'],
            )
            ->add('trainingExpensesFile', VichFileType::class, ['required' => false, 'label' => 'Frais de formation'])
            ->add('mileageExpensesFile', VichFileType::class, ['required' => false, 'label' => 'Frais de déplacement'])
            ->add('paymentDetailsFile', VichFileType::class, ['required' => false, 'label' => 'Détails de paiement'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrainingReimbursement::class,
        ]);
    }
}
