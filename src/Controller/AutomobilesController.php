<?php

namespace App\Controller;

use App\Entity\Automobiles;
use App\Form\AutomobilesType;
use App\Repository\AutomobilesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/automobiles')]
class AutomobilesController extends AbstractController
{
    #[Route('/', name: 'app_automobiles_index', methods: ['GET'])]
public function index(Request $request, AutomobilesRepository $automobilesRepository): Response
{
    $sortField = $request->query->get('sortField', 'model');
    $sortOrder = $request->query->get('sortOrder', 'ASC');
    

    switch ($sortField) {
        case 'brand':
            $sortField = 'brand';
            break;
        case 'model':
            $sortField = 'model';
            break;
        case 'year':
            $sortField = 'year';
            break;
        case 'to100InSec':
            $sortField = 'to_100_in_sec';
            break;
        default:
            $sortField = 'brand';
    }

    $automobiles = $automobilesRepository->findBy([], [$sortField => $sortOrder]);

    return $this->render('automobiles/index.html.twig', [
        'automobiles' => $automobiles,
        'sortField' => $sortField,
        'sortOrder' => $sortOrder,
    ]);
}

    #[Route('/new', name: 'app_automobiles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AutomobilesRepository $automobilesRepository): Response
    {
        $automobile = new Automobiles();
        $form = $this->createForm(AutomobilesType::class, $automobile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $automobilesRepository->save($automobile, true);

            return $this->redirectToRoute('app_automobiles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('automobiles/new.html.twig', [
            'automobile' => $automobile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_automobiles_show', methods: ['GET'])]
    public function show(Automobiles $automobile): Response
    {
        return $this->render('automobiles/show.html.twig', [
            'automobile' => $automobile,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_automobiles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Automobiles $automobile, AutomobilesRepository $automobilesRepository): Response
    {
        $form = $this->createForm(AutomobilesType::class, $automobile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $automobilesRepository->save($automobile, true);

            return $this->redirectToRoute('app_automobiles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('automobiles/edit.html.twig', [
            'automobile' => $automobile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_automobiles_delete', methods: ['POST'])]
    public function delete(Request $request, Automobiles $automobile, AutomobilesRepository $automobilesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$automobile->getId(), $request->request->get('_token'))) {
            $automobilesRepository->remove($automobile, true);
        }

        return $this->redirectToRoute('app_automobiles_index', [], Response::HTTP_SEE_OTHER);
    }
}
