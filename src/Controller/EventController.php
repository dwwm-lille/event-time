<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(EventRepository $repository): Response
    {
        // $events = $this->events;
        $events = $repository->findBy([], ['endAt' => 'DESC']);

        return $this->render('event/index.html.twig', [
            'events' => $events,
            // Je filtre les événements dont la date de début est supérieure à la date d'aujourd'hui
            'incoming' => count(array_filter($events, function ($event) {
                // On peut comparer des objets datetime ensemble
                // new \DateTime('2023-03-19') > new \DateTime('2023-03-17')
                // return $event['startAt'] > new \DateTime();
                return $event->getStartAt() > new \DateTime();
            })),
        ]);
    }

    #[Route('/evenement/nouveau', name: 'app_event_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $event = new Event();
        // Permet de pré-remplir les champs du formulaire
        $event->setStartAt(new \DateTimeImmutable());
        $event->setEndAt($event->getStartAt()->modify('+ 1 hour'));

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Permet d'avoir la date de création "automatiquement"
            $event->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($event);
            $manager->flush();

            $this->addFlash('success', 'Un événement '.$event->getName().' a été créé.');

            return $this->redirectToRoute('app_event');
        }
        return $this->render('event/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/evenement/{id}', name: 'app_event_show')]
    public function show(Event $event): Response
    {
        // Trouve l'index qui correspond à l'id
        // array_column($this->events, 'id') => [1, 2, 3]
        // array_search(2, [1, 2, 3]) => Index 1
        // $index = array_search($id, array_column($this->events, 'id'));

        // S'il n'y a pas l'id dans le tableau, 404
        // Attention l'index peut être 0 et il est correct dans ce cas (d'où le false)
        // if ($index === false) {
        //     throw $this->createNotFoundException();
        // }

        // $event = $this->events[$index];

        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/evenement/{id}/join', name: 'app_event_join')]
    public function join($id): Response
    {
        return new Response('<body>Rejoindre '.$id.'</body>');
    }
}
