<?php

namespace App\Form;

use App\Entity\TrainingReimbursement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class TrainingReimbursementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('trainee', null, ['label' => 'Nom de l\'apprenti'])
            ->add('traineeEmail', null, ['label' => 'Email de l\'apprenti'])
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
