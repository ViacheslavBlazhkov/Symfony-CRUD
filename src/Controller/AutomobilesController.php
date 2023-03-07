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
    public function index(Request $request, AutomobilesRepository $automobilesRepository): Response    {
        $sort = $request->query->get('sort', 'brand_asc');

        switch ($sort) {
            case 'brand_desc':
                $sortField = 'brand';
                $sortOrder = 'DESC';
                break;
                case 'model_asc':
                    $sortField = 'model';
                    $sortOrder = 'ASC';
                    break;
                case 'model_desc':
                    $sortField = 'model';
                    $sortOrder = 'DESC';
                    break;
            case 'year_asc':
                $sortField = 'year';
                $sortOrder = 'ASC';
                break;
            case 'year_desc':
                $sortField = 'year';
                $sortOrder = 'DESC';
                break;
            case 'to100InSec_asc':
                    $sortField = 'to_100_in_sec';
                    $sortOrder = 'ASC';
                    break;
            case 'to100InSec_desc':
                    $sortField = 'to100InSec';
                    $sortOrder = 'DESC';
                    break;
            default:
                $sortField = 'brand';
                $sortOrder = 'ASC';
        }
    
        $automobiles = $automobilesRepository->findBy([], [$sortField => $sortOrder]);
    
        return $this->render('automobiles/index.html.twig', [
            'automobiles' => $automobiles,
            'sort' => $sort,
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
