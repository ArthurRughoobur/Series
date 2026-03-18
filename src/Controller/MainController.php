<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class MainController extends AbstractController
{
    #[Route('', name: 'main_home')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig', [

        ]);
    }

    #[Route('/test', name: 'main_test')]
    public function test(SerializerInterface $serializer): Response
    {
        $serie = ['name'=> 'Dragon Ball Z', 'author'=> 'Toriyama', 'nbEpisode'=> 291];

        $username = '<h1>Arthur</h1>';


        //recupération depuis une API
        $joke = file_get_contents("https://api.chucknorris.io/jokes/random");
        $joke = json_decode($joke, true);
        dump($joke['value']);

//        dump($serializer->deserialize($joke, \stdClass::class, 'json'));
        return $this->render('main/test.html.twig', [
            'x' => $serie,
            'date'=> new \DateTime(),
            'username'=>$username
        ]);
    }
}
