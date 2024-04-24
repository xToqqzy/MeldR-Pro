<?php

namespace App\Repository;

use App\Entity\Melding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MeldingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Melding::class);
    }

    // Methode om meldingen op te halen op basis van het type melding
    public function findByTypeMelding(string $type_melding): array
    {
        // Bouw een query om meldingen op te halen met het opgegeven type melding
        $queryBuilder = $this->createQueryBuilder('m')
            ->andWhere('m.type_melding = :type_melding')
            ->setParameter('type_melding', $type_melding)
            ->getQuery();

        // Voer de query uit en retourneer het resultaat als een array van meldingen
        return $queryBuilder->getResult();
    }

    // Methode om meldingen op te halen op basis van longitudinaal en latitudinaal
    public function findByLongLat(float $longitude, float $latitude): array
    {
        // Bouw een query om meldingen op te halen met de opgegeven longitudinaal en latitudinaal
        $queryBuilder = $this->createQueryBuilder('m')
            ->andWhere('m.longitude = :longitude')
            ->andWhere('m.latitude = :latitude')
            ->setParameter('longitude', $longitude)
            ->setParameter('latitude', $latitude)
            ->getQuery();

        // Voer de query uit en retourneer het resultaat als een array van meldingen
        return $queryBuilder->getResult();
    }
}
