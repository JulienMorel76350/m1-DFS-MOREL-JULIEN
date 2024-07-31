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

}
