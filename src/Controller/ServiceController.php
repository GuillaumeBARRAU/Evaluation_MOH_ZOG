<?php

namespace App\Controller;

use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/services')]
class ServiceController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // GET /services - Récupérer la liste des services
    #[Route('/', name: 'service_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $services = $this->entityManager->getRepository(Service::class)->findAll();
        return $this->json($services);
    }

    // POST /services - Ajouter un service
    #[Route('/', name: 'service_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $service = new Service();
        $service->setName($data['name']);
        $service->setDescription($data['description']);

        $this->entityManager->persist($service);
        $this->entityManager->flush();

        return $this->json($service, Response::HTTP_CREATED);
    }

    // PUT /services/{id} - Modifier un service
    #[Route('/{id}', name: 'service_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $service = $this->entityManager->getRepository(Service::class)->find($id);
        if (!$service) {
            return $this->json(['message' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $service->setName($data['name'] ?? $service->getName());
        $service->setDescription($data['description'] ?? $service->getDescription());

        $this->entityManager->flush();

        return $this->json($service);
    }

    // DELETE /services/{id} - Supprimer un service
    #[Route('/{id}', name: 'service_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $service = $this->entityManager->getRepository(Service::class)->find($id);
        if (!$service) {
            return $this->json(['message' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($service);
        $this->entityManager->flush();

        return $this->json(['message' => 'Service deleted'], Response::HTTP_NO_CONTENT);
    }
}

