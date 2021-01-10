<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\LocationIsNotResolvedException;
use App\Location\LocationResolver;
use App\Model\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class LocationController extends AbstractController
{
    private LocationResolver $locationService;
    private SerializerInterface $serializer;

    public function __construct(
        LocationResolver $locationService,
        SerializerInterface $serializer
    ) {
        $this->locationService = $locationService;
        $this->serializer = $serializer;
    }

    public function index(Request $request): Response
    {
        $location = $this->createLocation($request);

        try {
            $this->locationService->resolveLocation($location);
        } catch (LocationIsNotResolvedException $e) {
            return new JsonResponse(
                [ 'error' => $e->getMessage() ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $dto = $this->serializer->serialize($location, 'json');

        return new Response($dto, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }

    private function createLocation(Request $request): Location
    {
        $data = $request->getContent();

        return $this->serializer->deserialize(
            $data,
            Location::class,
            'json',
            [
                AbstractNormalizer::IGNORED_ATTRIBUTES => [ 'resolved' ],
            ]
        );
    }
}
