<?php

namespace App\Entity;

use App\Repository\TrainingReimbursementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: TrainingReimbursementRepository::class)]
#[Vich\Uploadable]
class TrainingReimbursement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public string $trainee;

    #[ORM\Column(length: 255)]
    public string $traineeEmail;

    #[ORM\Column(length: 255)]
    public string $token;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $trainingCompletionCertificate = null;

    #[Vich\UploadableField(mapping: 'file', fileNameProperty: 'trainingCompletionCertificate')]
    public ?File $trainingCompletionCertificateFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $trainingExpenses = null;

    #[Vich\UploadableField(mapping: 'file', fileNameProperty: 'trainingExpenses')]
    public ?File $trainingExpensesFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $mileageExpenses = null;

    #[Vich\UploadableField(mapping: 'file', fileNameProperty: 'mileageExpenses')]
    public ?File $mileageExpensesFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $paymentDetails = null;

    #[Vich\UploadableField(mapping: 'file', fileNameProperty: 'paymentDetails')]
    public ?File $paymentDetailsFile = null;

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column]
    public \DateTimeImmutable $updatedAt;

    #[ORM\Column(length: 255)]
    public ?string $licenseNumber = null;

    #[ORM\Column(length: 255)]
    public ?string $status = 'draft';

    #[ORM\Column]
    public ?int $amount = null;

    #[ORM\Column]
    public ?int $paidAmount = 0;

    #[ORM\Column(length: 255)]
    public ?string $activity = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->token = bin2hex(random_bytes(12));
    }

    public function isComplete(): bool
    {
        return $this->trainingCompletionCertificate && $this->trainingExpenses && $this->mileageExpenses && $this->paymentDetails;
    }
}
