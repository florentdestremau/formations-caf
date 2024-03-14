<?php

namespace App\Controller;

use App\Entity\TrainingReimbursement;
use App\Form\TrainingReimbursementType;
use App\Repository\TrainingReimbursementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/training-reimbursement')]
class TrainingReimbursementController extends AbstractController
{
    #[Route('', name: 'app_training_reimbursement_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(TrainingReimbursementRepository $trainingReimbursementRepository): Response
    {
        return $this->render('training_reimbursement/index.html.twig', [
            'training_reimbursements' => $trainingReimbursementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_training_reimbursement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trainingReimbursement = new TrainingReimbursement();
        $form = $this->createForm(TrainingReimbursementType::class, $trainingReimbursement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trainingReimbursement);
            $entityManager->flush();

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_training_reimbursement_index');
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('training_reimbursement/new.html.twig', [
            'training_reimbursement' => $trainingReimbursement,
            'form'                   => $form,
        ]);
    }

    #[Route('/{token}', name: 'app_training_reimbursement_show', methods: ['GET'])]
    public function show(TrainingReimbursement $trainingReimbursement): Response
    {
        return $this->render('training_reimbursement/show.html.twig', [
            'training_reimbursement' => $trainingReimbursement,
        ]);
    }

    #[Route('/{token}/edit', name: 'app_training_reimbursement_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        TrainingReimbursement $trainingReimbursement,
        EntityManagerInterface $entityManager,
    ): Response {
        $form = $this->createForm(TrainingReimbursementType::class, $trainingReimbursement);
        $trainingReimbursement->updatedAt = new \DateTimeImmutable();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_training_reimbursement_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->redirectToRoute(
                'app_training_reimbursement_show',
                ['token' => $trainingReimbursement->token],
                Response::HTTP_SEE_OTHER,
            );
        }

        return $this->render('training_reimbursement/edit.html.twig', [
            'training_reimbursement' => $trainingReimbursement,
            'form'                   => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_training_reimbursement_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(
        Request $request,
        TrainingReimbursement $trainingReimbursement,
        EntityManagerInterface $entityManager,
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $trainingReimbursement->id, $request->request->get('_token'))) {
            $entityManager->remove($trainingReimbursement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_training_reimbursement_index', [], Response::HTTP_SEE_OTHER);
    }
}
