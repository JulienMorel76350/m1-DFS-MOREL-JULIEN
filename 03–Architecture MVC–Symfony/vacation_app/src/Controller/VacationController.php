<?php

namespace App\Controller;

use App\Entity\Vacation;
use App\Form\VacationType;
use App\Repository\VacationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/vacations')]
class VacationController extends AbstractController
{
    #[Route('/', name: 'vacation_index', methods: ['GET'])]
    public function index(VacationRepository $vacationRepository): Response
    {
        // Check if the user is authenticated
        if (!$this->getUser()) {
            $this->addFlash('error', 'You need to be connected to see your vacation.');
            // Redirect to login page if not authenticated
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        return $this->render('vacation/index.html.twig', [
            'vacations' => $vacationRepository->findBy(['user' => $user]),
        ]);
    }

    #[Route('/new', name: 'vacation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Check if the user is authenticated
        if (!$this->getUser()) {
            $this->addFlash('error', 'You need to be connected to create a new vacation.');
            // Redirect to login page if not authenticated
            return $this->redirectToRoute('app_login');
        }

        $vacation = new Vacation();
        $form = $this->createForm(VacationType::class, $vacation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vacation->setUser($this->getUser());
            $vacation->setStatus('Requested');
            $entityManager->persist($vacation);
            $entityManager->flush();

            return $this->redirectToRoute('vacation_index');
        }

        return $this->render('vacation/new.html.twig', [
            'vacation' => $vacation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'vacation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vacation $vacation, EntityManagerInterface $entityManager): Response
    {
        // Check if the user is authenticated
        if (!$this->getUser()) {
            $this->addFlash('error', 'You need to be connected to edit a vacation.');
            // Redirect to login page if not authenticated
            return $this->redirectToRoute('app_login');
        }

        if ($vacation->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'You cannot edit this vacation.');
            return $this->redirectToRoute('vacation_index');
        }

        if ($vacation->getStatus() == 'Validated') {
            $this->addFlash('error', 'You cannot edit a validated vacation.');
            return $this->redirectToRoute('vacation_index');
        }
        if ($vacation->getStatus() == 'Cancelled') {
            $this->addFlash('error', 'You cannot edit a validated vacation.');
            return $this->redirectToRoute('vacation_index');
        }

        $form = $this->createForm(VacationType::class, $vacation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('vacation_index');
        }

        return $this->render('vacation/edit.html.twig', [
            'vacation' => $vacation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'vacation_delete', methods: ['POST'])]
    public function delete(Request $request, Vacation $vacation, EntityManagerInterface $entityManager): Response
    {
        // Check if the user is authenticated
        if (!$this->getUser()) {
            $this->addFlash('error', 'You need to be connected to delete a vacation.');
            // Redirect to login page if not authenticated
            return $this->redirectToRoute('app_login');
        }

        if ($vacation->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'You cannot delete this vacation.');
            return $this->redirectToRoute('vacation_index');
        }

        if ($this->isCsrfTokenValid('delete' . $vacation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vacation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vacation_index');
    }

    #[Route('/{id}/approve', name: 'vacation_approve', methods: ['POST'])]
    public function approve(Request $request, Vacation $vacation, EntityManagerInterface $entityManager): Response
    {
        // Check if the user is authenticated
        if (!$this->getUser()) {
            $this->addFlash('error', 'You need to be connected to approve a vacation.');
            // Redirect to login page if not authenticated
            return $this->redirectToRoute('app_login');
        }

        if ($vacation->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'You cannot approve this vacation.');
            return $this->redirectToRoute('vacation_index');
        }

        if ($vacation->getStatus() == 'Requested' && $this->isCsrfTokenValid('approve' . $vacation->getId(), $request->request->get('_token'))) {
            $vacation->setStatus('Validated');
            $entityManager->flush();
        }

        return $this->redirectToRoute('vacation_index');
    }

    #[Route('/{id}/reject', name: 'vacation_reject', methods: ['POST'])]
    public function reject(Request $request, Vacation $vacation, EntityManagerInterface $entityManager): Response
    {
        if ($vacation->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'You cannot reject this vacation.');
            return $this->redirectToRoute('vacation_index');
        }

        if ($vacation->getStatus() == 'Requested' && $this->isCsrfTokenValid('reject' . $vacation->getId(), $request->request->get('_token'))) {
            $vacation->setStatus('Refused');
            $entityManager->flush();
        }

        return $this->redirectToRoute('vacation_index');
    }

    #[Route('/{id}/cancel', name: 'vacation_cancel', methods: ['POST'])]
    public function cancel(Request $request, Vacation $vacation, EntityManagerInterface $entityManager): Response
    {
        if ($vacation->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'You cannot cancel this vacation.');
            return $this->redirectToRoute('vacation_index');
        }

        if ($this->isCsrfTokenValid('cancel' . $vacation->getId(), $request->request->get('_token'))) {
            $vacation->setStatus('Cancelled');
            $entityManager->flush();
        }

        return $this->redirectToRoute('vacation_index');
    }
}
