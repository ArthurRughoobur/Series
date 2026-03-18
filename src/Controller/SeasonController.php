<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/season', name: 'season_')]
final class SeasonController extends AbstractController
{

    #[Route('/add', name: 'add')]
    #[Route("/add/serie/{id}", name: 'add_by_serie', requirements: ['id' => '\d+'])]
//    #[IsGranted("ROLE_ADMIN")]
    public function add(
        Request                $request,
        EntityManagerInterface $entityManager,
        SerieRepository $serieRepository,
        int $id = null
    ): Response
    {



        $season = new Season();
        if ($id) {
            $serie = $serieRepository->find($id);
            $season->setSerie($serie);
            $season->setNumber(count($serie->getSeasons()) + 1);
        }
        $seasonForm = $this->createForm(SeasonType::class, $season);
        $seasonForm->handleRequest($request);

        if ($seasonForm->isSubmitted() && $seasonForm->isValid()) {

            $season->setDateCreated(new \DateTime());
            $entityManager->persist($season);
            $entityManager->flush();

            $this->addFlash('success', 'Season added !');
            return $this->redirectToRoute('series_show', ['id' => $season->getSerie()->getId()]);
        }

        return $this->render('season/add.html.twig', [
            'seasonForm' => $seasonForm
        ]);

    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d+'])]
    public function update(int $id): Response
    {
        //TODO formulaire de updation de saison
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '\d+'])]
    public function delete(
        int                    $id,
        EntityManagerInterface $entityManager,
        SeasonRepository       $seasonRepository
    ): Response
    {
        //récupération de la saison pour pouvoir la supprimer
        $season = $seasonRepository->find($id);

        $entityManager->remove($season);
        $entityManager->flush();

        $this->addFlash('success', 'Season deleted !');
        return $this->redirectToRoute('series_show', ['id' => $season->getSerie()->getId()]);
    }
}
