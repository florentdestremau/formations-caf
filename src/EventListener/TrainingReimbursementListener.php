<?php

namespace App\EventListener;

use App\Entity\TrainingReimbursement;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEntityListener(entity: TrainingReimbursement::class)]
final class TrainingReimbursementListener
{
    public function __construct(private NotifierInterface $notifier, private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function postPersist(TrainingReimbursement $trainingReimbursement, PostPersistEventArgs $args): void
    {
        $notification = new Notification('Votre dossier a bien été créé', ['email']);
        $link = $this->urlGenerator->generate(
            'app_training_reimbursement_edit',
            ['token' => $trainingReimbursement->token],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );
        $notification->content(
            <<<EOM
            Votre demande de remboursement de formation a bien été reçue. Vous pouvez l'éditer à tout moment sur ce lien:
            
            $link
            
            En cas de question, n'hésitez pas à nous contacter.
        EOM,
        );
        $notification->importance('');

        $recipient = new Recipient($trainingReimbursement->traineeEmail);
        $this->notifier->send($notification, $recipient);
    }
}
