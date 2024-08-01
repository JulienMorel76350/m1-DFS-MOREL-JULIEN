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

#[Route('/vacations')]
class VacationController extends AbstractController
{
    #[Route('/', name: 'vacation_index', methods: ['GET'])]
    public function index(VacationRepository $vacationRepository): Response
    {
        $user = $this->getUser();
        return $this->render('vacation/index.html.twig', [
            'vacations' => $vacationRepository->findBy(['user' => $user]),
        ]);
    }

    #[Route('/new', name: 'vacation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
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
     //   $this->denyAccessUnlessGranted('edit', $vacation);

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
      //  $this->denyAccessUnlessGranted('delete', $vacation);

        if ($this->isCsrfTokenValid('delete' . $vacation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vacation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vacation_index');
    }

    #[Route('/{id}/approve', name: 'vacation_approve', methods: ['POST'])]
    public function approve(Request $request, Vacation $vacation, EntityManagerInterface $entityManager): Response
    {
        //$this->denyAccessUnlessGranted('edit', $vacation);

        if ($this->isCsrfTokenValid('approve' . $vacation->getId(), $request->request->get('_token'))) {
            $vacation->setStatus('Approved');
            $entityManager->flush();
        }

        return $this->redirectToRoute('vacation_index');
    }

    #[Route('/{id}/reject', name: 'vacation_reject', methods: ['POST'])]
    public function reject(Request $request, Vacation $vacation, EntityManagerInterface $entityManager): Response
    {
        //    $this->denyAccessUnlessGranted('edit', $vacation);

        if ($this->isCsrfTokenValid('reject' . $vacation->getId(), $request->request->get('_token'))) {
            $vacation->setStatus('Rejected');
            $entityManager->flush();
        }

        return $this->redirectToRoute('vacation_index');
    }

    #[Route('/{id}/cancel', name: 'vacation_cancel', methods: ['POST'])]
    public function cancel(Request $request, Vacation $vacation, EntityManagerInterface $entityManager): Response
    {
       // $this->denyAccessUnlessGranted('delete', $vacation);

        if ($this->isCsrfTokenValid('cancel' . $vacation->getId(), $request->request->get('_token'))) {
            $vacation->setStatus('Cancelled');
            $entityManager->flush();
        }

        return $this->redirectToRoute('vacation_index');
    }
}
