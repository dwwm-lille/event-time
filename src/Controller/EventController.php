<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    protected $events = [];

    public function __construct()
    {
        $this->events = [
            ['id' => 1, 'name' => 'Concert 1', 'description' => 'Lorem', 'price' => 10, 'createdAt' => new \DateTime('2023-03-14 11:38:45'), 'startAt' => new \DateTime('2023-03-14 11:38:45'), 'endAt' => new \DateTime('2023-03-15 11:38:45')],
            ['id' => 2, 'name' => 'Concert 2', 'description' => 'Lorem', 'price' => 20, 'createdAt' => new \DateTime('2023-03-16 10:38:45'), 'startAt' => new \DateTime('2023-03-16 10:38:45'), 'endAt' => new \DateTime('2023-03-18 11:38:45')],
            ['id' => 3, 'name' => 'Concert 3', 'description' => 'Lorem', 'price' => 30, 'createdAt' => new \DateTime('2023-03-18 11:38:45'), 'startAt' => new \DateTime('2023-03-18 11:38:45'), 'endAt' => new \DateTime('2023-03-19 11:38:45')],
        ];
    }

    #[Route('/evenements', name: 'app_event')]
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $this->events,
            'incoming' => count(array_filter($this->events, function ($event) {
                return $event['startAt'] > new \DateTime();
            })),
        ]);
    }

    #[Route('/evenement/nouveau', name: 'app_event_create')]
    public function create(): Response
    {
        return $this->render('event/create.html.twig');
    }

    #[Route('/evenement/{id}', name: 'app_event_show')]
    public function show($id): Response
    {
        // Trouve l'index qui correspond à l'id
        $index = array_search($id, array_column($this->events, 'id'));

        // S'il n'y a pas l'id dans le tableau, 404
        if ($index === false) {
            throw $this->createNotFoundException();
        }

        return $this->render('event/show.html.twig', [
            'event' => $this->events[$index],
        ]);
    }

    #[Route('/evenement/{id}/join', name: 'app_event_join')]
    public function join($id): Response
    {
        return new Response('<body>Rejoindre '.$id.'</body>');
    }
}
