<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pokemon>
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }
    public function findLikeTitle($search)
    {
        $queryBuilder = $this->createQueryBuilder('pokemon');
        // on crée une nouvelle methode qui permet de recuperer le constructeur de requete Sql en restant en php, alias c'est pour le nom de la table
        $query = $queryBuilder->select('pokemon')     // on lui demande de selectionner tous les Pokemons
            ->where('pokemon.Title LIKE :search') // remplace recherche par recherche souple, bien mettre Title avec un T maj si on en a mis en creant sa colonne, par convention on mettra une minuscule title en BDD
            ->setParameter('search','%'.$search.'%') // %% peu importe où les lettres vont se trouver en effectuant la recherche
            ->getQuery(); //

        $pokemons = $query->getResult(); // on recupere la liste des resultats  pour la requete

        return $pokemons; // on retourne le resultat
    }




//    /**
//     * @return Pokemon[] Returns an array of Pokemon objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pokemon
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
