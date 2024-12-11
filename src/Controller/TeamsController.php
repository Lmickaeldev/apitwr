<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class TeamsController extends AbstractController
{
    #[Route('/', name: 'app_teams')]
    public function fetchTeams(): Response
    {
        $httpClient = HttpClient::create();

        try {
            $response = $httpClient->request('GET', 'https://rustoria.co/twitch/api/teams/krolay');
            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                throw new \Exception('Failed to fetch data from the API.');
            }

            $teams = $response->toArray(); // Décodage JSON en tableau PHP
            //dd($teams);
            return $this->render('teams/index.html.twig', [
                'teams' => $teams,
            ]);
        } catch (\Exception $e) {
            return $this->render('error.html.twig', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
