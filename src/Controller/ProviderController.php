<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/providers')]
class ProviderController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private NotificationService $notificationService;

    public function __construct(EntityManagerInterface $entityManager, NotificationService $notificationService)
    {
        $this->entityManager = $entityManager;
        $this->notificationService = $notificationService;
    }

    // POST /providers - Ajouter un nouveau prestataire
    #[Route('/', name: 'provider_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $provider = new Provider();
        $provider->setName($data['name']);
        $provider->setEmail($data['email']);

        $this->entityManager->persist($provider);
        $this->entityManager->flush();

        // Envoyer un email après la création
        $this->notificationService->sendProviderNotification(
            $provider,
            'Your Provider Account has been created',
            'Your provider account is now active.'
        );

        return $this->json($provider, Response::HTTP_CREATED);
    }

    // PUT /providers/{id} - Modifier un prestataire
    #[Route('/{id}', name: 'provider_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $provider = $this->entityManager->getRepository(Provider::class)->find($id);
        if (!$provider) {
            return $this->json(['message' => 'Provider not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $provider->setName($data['name'] ?? $provider->getName());
        $provider->setEmail($data['email'] ?? $provider->getEmail());

        $this->entityManager->flush();

        // Envoyer un email après la mise à jour
        $this->notificationService->sendProviderNotification(
            $provider,
            'Your Provider Account has been updated',
            'Your provider account details have been updated.'
        );

        return $this->json($provider);
    }
}
