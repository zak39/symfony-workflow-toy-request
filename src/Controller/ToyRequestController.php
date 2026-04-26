<?php

namespace App\Controller;

use App\Entity\ToyRequest;
use App\Form\ToyRequestType;
use App\Repository\ToyRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Workflow\WorkflowInterface;

final class ToyRequestController extends AbstractController
{
    public function __construct(
        private WorkflowInterface $toyRequestWorkflow
    )
    {
    }

    #[Route('/parent', name: 'app_toy_parent')]
    public function parent(ToyRequestRepository $repository): Response
    {
        $toys = $repository->findAll();

        return $this->render('parent/index.html.twig', [
            'toys' => $toys
        ]);
    }

    #[Route('/change/{id}/{to}', name: 'app_toy_change')]
    public function change(ToyRequest $toy, string $to, EntityManagerInterface $entityManager): Response
    {
        try {
            $this->toyRequestWorkflow->apply($toy, $to);
        } catch (LogicException $exception) {
            //
        }

        $entityManager->persist($toy);
        $entityManager->flush();

        $this->addFlash('success', 'Action enregistré');

        return $this->redirectToRoute('app_toy_parent');
    }


    #[Route('/new', name: 'app_toy_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $toy = new ToyRequest();

        $toy->setKid($this->getUser());

        $form = $this->createForm(ToyRequestType::class, $toy);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $toy = $form->getData();

            try {
                // Appliquer la transition 'to_pending' pour passer le jouet à l'état 'pending'
                $this->toyRequestWorkflow->apply($toy, 'to_pending');
            } catch (LogicException  $exception) {
                //
            }

            $entityManager->persist($toy);
            $entityManager->flush();

            $this->addFlash('success', 'Demande Enregistré');

            return $this->redirectToRoute('app_toy_new');
        }

        return $this->render('toy_request/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
