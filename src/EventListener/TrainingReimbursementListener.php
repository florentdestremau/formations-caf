<?php

namespace App\EventListener;

use App\Entity\TrainingReimbursement;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEntityListener(entity: TrainingReimbursement::class)]
final readonly class TrainingReimbursementListener
{
    public function __construct(private NotifierInterface $notifier, private UrlGeneratorInterface $urlGenerator) {}

    public function postPersist(TrainingReimbursement $trainingReimbursement, PostPersistEventArgs $args): void
    {
        $this->sendTrainingReimbursementEmail($trainingReimbursement);

        if ($trainingReimbursement->isComplete()) {
            $this->sendTrainingReimbursementCompleteNotification($trainingReimbursement);
        }
    }

    public function postUpdate(TrainingReimbursement $trainingReimbursement, PostUpdateEventArgs $args): void
    {
        $this->sendTrainingReimbursementUpdatedNotification($trainingReimbursement);

        if ($trainingReimbursement->isComplete()) {
            $this->sendTrainingReimbursementCompleteNotification($trainingReimbursement);
        }
    }

    private function sendTrainingReimbursementCompleteNotification(TrainingReimbursement $trainingReimbursement): void
    {
        $recipient = new Recipient($trainingReimbursement->traineeEmail);
        $traineeNotification = new Notification('Votre dossier est complet', ['email']);
        $traineeNotification->content(
            <<<'EOM'
                Votre demande de remboursement de formation est complète. Nous allons l'examiner dans les plus brefs délais.
                En cas de question, n'hésitez pas à nous contacter.
            EOM,
        );
        $traineeNotification->importance('');
        $this->notifier->send($traineeNotification, $recipient);

        $adminNotification = new Notification('Nouveau dossier complet', ['email']);
        $showLink = $this->urlGenerator->generate(
            'app_training_reimbursement_show',
            ['token' => $trainingReimbursement->token],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );
        $adminNotification->content(
            <<<EOM
                Un nouveau dossier de remboursement de formation a été créé. Vous pouvez le consulter sur ce lien:
                
                {$showLink}
            EOM,
        );
        $adminNotification->importance('');
        $this->notifier->send($adminNotification, new Recipient('admin@cafannecy.fr'));
    }

    /**
     * @return Recipient
     */
    private function sendTrainingReimbursementEmail(TrainingReimbursement $trainingReimbursement): void
    {
        $notification = new Notification('Votre dossier a bien été créé', ['email', 'browser']);
        $link = $this->urlGenerator->generate(
            'app_training_reimbursement_edit',
            ['token' => $trainingReimbursement->token],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );
        $notification->content(
            <<<EOM
            Votre demande de remboursement de formation a bien été reçue. Vous pouvez l'éditer à tout moment sur ce lien:
            
            {$link}
            
            En cas de question, n'hésitez pas à nous contacter.
        EOM,
        );
        $notification->importance(Notification::IMPORTANCE_LOW);

        $recipient = new Recipient($trainingReimbursement->traineeEmail);
        $this->notifier->send($notification, $recipient);
    }

    private function sendTrainingReimbursementUpdatedNotification(TrainingReimbursement $trainingReimbursement): void
    {
        $notification = new Notification('Votre dossier a bien été mis à jour', ['email']);
        $link = $this->urlGenerator->generate(
            'app_training_reimbursement_edit',
            ['token' => $trainingReimbursement->token],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );
        $notification->content(
            <<<EOM
            Votre demande de remboursement de formation a bien été mise à jour. Vous pouvez l'éditer à tout moment sur ce lien:
            
            {$link}
            
            En cas de question, n'hésitez pas à nous contacter.
        EOM,
        );
        $notification->importance('');

        $recipient = new Recipient($trainingReimbursement->traineeEmail);
        $this->notifier->send($notification, $recipient);
    }
}
