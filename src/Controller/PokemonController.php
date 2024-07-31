<?php

declare(strict_types=1); // pour etre sur de l'affichage permet de reperer les erreurs par ex du string alors qu on attend un integer
namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function PHPUnit\Framework\isEmpty;
use Symfony\Component\Validator\Validator\ValidatorInterface;
class PokemonController extends AbstractController
{

    private $pokemons;

    public function __construct()
    {


        $this->pokemons = [
            [
                'id' => 1,
                'title' => 'Pikachu',
                'content' => 'Pokemon electric',
                'image' => 'https://pelucheuniverse.com/img/zbp/3/4/34-large.jpg',
                'isPublished' => true
            ], [
                'id' => 2,
                'title' => 'Carapuce',
                'content' => 'Pokemon eau',
                'image' => 'https://www.pokepedia.fr/images/thumb/c/cc/Carapuce-RFVF.png/800px-Carapuce-RFVF.png',
                'isPublished' => true
            ],
            [
                'id' => 3,
                'title' => 'Salamèche',
                'content' => 'Pokemon feu',
                'image' => 'https://www.pokepedia.fr/images/thumb/8/89/Salam%C3%A8che-RFVF.png/800px-Salam%C3%A8che-RFVF.png',
                'isPublished' => true
            ],
            [
                'id' => 4,
                'title' => 'Bulbizarre',
                'content' => 'Pokemon plante',
                'image' => 'https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/001.png',
                'isPublished' => true
            ],
            [
                'id' => 5,
                'title' => 'Dynavolt',
                'content' => 'Pokemon electrique',
                'image' => 'https://www.pokepedia.fr/images/thumb/0/07/Dynavolt-RS.png/800px-Dynavolt-RS.png',
                'isPublished' => false
            ],
            [
                'id' => 6,
                'title' => 'Rattata',
                'content' => 'Pokemon normal',
                'image' => 'https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/019.png',
                'isPublished' => true
            ],
            [
                'id' => 7,
                'title' => 'Roucool',
                'content' => 'Pokemon vol',
                'image' => 'https://www.pokepedia.fr/images/9/94/Roucool-RFVF.png',
                'isPublished' => false
            ],
            [
                'id' => 8,
                'title' => 'Aspicot',
                'content' => 'Pokemon insecte',
                'image' => 'https://www.pokepedia.fr/images/9/9b/Aspicot-RFVF.png',
                'isPublished' => true
            ],
            [
                'id' => 9,
                'title' => 'Nosferapti',
                'content' => 'Pokemon poison',
                'image' => 'https://www.pokepedia.fr/images/thumb/2/2b/Nosferapti-RFVF.png/800px-Nosferapti-RFVF.png',
                'isPublished' => true
            ],
            [
                'id' => 10,
                'title' => 'Mewtwo',
                'content' => 'Pokemon psy',
                'image' => 'https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/150.png',
                'isPublished' => true
            ],
            [
                'id' => 11,
                'title' => 'Ronflex',
                'content' => 'Pokemon normal',
                'image' => 'data:image/jpeg;base64,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',
                'isPublished' => true
            ]
        ];


    }

    #[Route('/pokemon_show/{idPokemon}', name: 'show_pokemon')]
    public function showPokemon($idPokemon, Request $request): Response
        // je type ma variable $request elle n acceptera que la classe request
        //en typant ma methode je retourne une instance de la classe Response
    {
//        $request= new Request($_GET, $_POST, etc);
//        $request = Request::createFromGlobals();
//        $idPokemon = $request->query->get('id');


        $pokemonFound = null;

        foreach ($this->pokemons as $pokemon) {
            if ($pokemon['id'] === (int)$idPokemon) {
                $pokemonFound = $pokemon;
            }

        }


        return $this->render('Page/pokemon_show.html.twig', [
            'pokemon' => $pokemonFound
        ]);  //si on veut typer le return on fait Response, en typant ma methode je retourne une instance de la classe Response

    }

    #[Route('/categories', name: 'list_categories')]
    public function listCategories()
    {
        $categories = [
            'Red', 'Green', 'Blue', 'Yellow', 'Gold', 'Silver', 'Crystal'
        ];

        $html = $this->renderView('Page/categories.html.twig', ['categories' => $categories]); // $html = $this->renderView   Ne pas oublier c est renderView ici

        return new Response ($html, 200); // pour me retourner un status 200
    }

    #[Route('/pokemon-list-db', name: 'pokemon_list_db')]
    public function listPokemonFromDb(PokemonRepository $pokemonRepository): Response
    {
        $pokemons = $pokemonRepository->findAll();

        return $this->render('Page/pokemon_list_db.html.twig', ['pokemons' => $pokemons]);
    }

// apres avoir crée des pokemons dans ma BDD (php myadmin), je recupere en BDD les pokemons, symfony va générer une instance de PokemonRepository qui me permet de faire des requêtes SQL dans la table pokemon // Symfony va generer une instance de la Table Pokemon -> il va creer un tableau avec les pokemons a recuperer


    #[Route('/pokemon-db/{id}', name: 'pokemon_db_by_id')]
    public function showPokemonById(int $id, PokemonRepository $pokemonRepository): Response
    {

        $pokemon = $pokemonRepository->find($id);
        return $this->render('Page/pokemon-db.html.twig', ['pokemon' => $pokemon]);
    }

    #[Route('/pokemon_search', name: 'pokemon_search')]
    public function searchPokemon(Request $request, PokemonRepository $pokemonRepository): Response
    {

        $pokemonsFound = [];

        if ($request->request->has('title')) {

            $titleSearched = $request->request->get('title');
            $pokemonsFound = $pokemonRepository->findLikeTitle($titleSearched);

            if (count($pokemonsFound) === 0) {
                $html = $this->renderView('Page/404.html.twig');
                return new Response ($html, 404);
            }
        }


        return $this->render('Page/pokemon-search.html.twig', ['pokemons' => $pokemonsFound]);


    }

    #[Route('/pokemons/delete/{id}', name: 'delete_pokemon')]
    public function deletePokemon(int $id, PokemonRepository $pokemonRepository, EntityManagerInterface $entityManager): Response
    {
        $pokemon = $pokemonRepository->find($id); // on instancie la classe PokemonRepository et on stocke dans la variable $pokemon
        // on utilise la classe Entity Manager pour
        if (!$pokemon) {

            $html = $this->renderView('Page/404.html.twig');
            return new Response ($html, 404);
        }

        $entityManager->remove($pokemon); //preparation : preparer la requete Sql de suppression
        $entityManager->flush(); // execute : executer la requete préparée


        return $this->redirectToRoute('pokemon_list_db'); // je redirige vers ma page list pokemon Bdd et je check si le pokemon a été supprimé

    }

//    #[Route('/insert-pokemon-withform', name: 'insert_pokemon_withform')]
//    public function insertPokemonWithForm (EntityManagerInterface $entityManager, Request $request): Response
//    {   // j'initialise la variable //$pokemon à null
//        $pokemon = null;
//        // je check si la requête est du POST, si le form a été envoyé
//        if ($request->getMethod() === 'POST') {
//            // je récupère les données envoyées par l'utilisateur
//            $title = $request->request->get('title');
//            $description = $request->request->get('description');
//            $image = $request->request->get('image');
//            $type = $request->request->get('type');
//
////pour la premiere methode avec le construct
////        $pokemon = new Pokemon(
////            title: 'Roucoups',
////            description: 'Roucoups est l évolution de Roucool au niveau 18, et il évolue en Roucarnage à partir du niveau 36',
////            image: 'https://www.pokepedia.fr/images/d/d3/Miniature_0018_DEPS.png',
////            type: 'vol',
////
////        );
//            $pokemon = new Pokemon();
//            // j'instancie la classe pokemon
//            // deuxieme  methode la premiere etant directement  dans le construct dans pokemon.php
//
//            $pokemon->setTitle($title);
//            $pokemon->setDescription($description);
//            $pokemon->setImage($image);
//            $pokemon->setType($type);
//            // je passe desormais en valeur des propriétés de la classe pokemon
//            //les données envoyées par l'utilisateur grâce aux fonctions setters
//
//            $entityManager->persist($pokemon); //preparation : preparer la requete Sql de suppression
//            $entityManager->flush(); // execute : executer la requete préparée
//            // j'enregistre l'instance de la classe
//            // pokemon dans la table pokemon
//            // grâce à la classe EntityManager
//        }
//
//        return $this->render('Page/insert-pokemon-withform.html.twig', [
//            'pokemon' => $pokemon,
//        ]);
//        // je retourne une réponse HTTP
//        // avec le html du formulaire
//    }

    #[Route('/pokemon-insert-formbuilder', name: 'pokemon_insert_formbuilder')]
    public function insertPokemonFormBuilder(EntityManagerInterface $entityManager, Request $request): Response
    {
        // j ai cree au prealable dans mon terminale en ligne de commande  une classe de "gabarit de formulaire HTML" avec php bin/console make:form, que j ai appelé Pokemon Type qui va etre relié a mon Entity Pokemon (BDD)

        $pokemon = new Pokemon();
        // j'instancie la classe pokemon


        $pokemonForm = $this->createForm(PokemonType::class, $pokemon);
        // ici je génére une instance de la classe de gabarit de formulaire PokemonType qui va etre reliée a l'Entity Pokemon (BDD), createForm vient de la classe Parent
        $pokemonForm->handleRequest($request);
        // le handle request permet de lier le formulaire avec la requête, il recupere les données postées dans la variable (du POST et les stock dans l'Entity)
        if ($pokemonForm->isSubmitted() && $pokemonForm->isValid()) {
            // si le formulaire est submit et qu il est valide alors, le handlerequest sait si cela a été posté ou pas
            $entityManager->persist($pokemon); // preparation : on prepare la requete Sql
            $entityManager->flush(); // execute : on execute la requete préparée
        }

        return $this->render('Page/pokemon-insert-formbuilder.html.twig', [
            'pokemon' => $pokemon,
            'pokemonForm' => $pokemonForm->createView()


        ]);
        // je retourne une réponse HTTP avec le html de pokemonForm

        // on peut retourner autant de variables qu on veut


    }

    // je cree une methode avec une route je m assure au prealable que cela marche avec
    //un dd (vars:'test'） ；
    #[Route('/pokemons/update/{id}', name: 'pokemon_update')]
    public function updatePokemon(int $id,PokemonRepository $pokemonRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $pokemon = $pokemonRepository->find($id);
        // j'instancie la classe pokemonRepository, pour acceder a des données stockées on utilise Repository, je demande donc a Symfony d'instancier la classe Repository (dans le controller : ici PokemonController)
        // on aura placer l $id en parametre


        $pokemonUpdateForm = $this->createForm(PokemonType::class, $pokemon);
        // ici je génére une nouvelle instance de la classe de gabarit de formulaire PokemonType (on peut creer plusieurs instances d'une meme classe) qui va etre reliée a l'Entity Pokemon (BDD), createForm vient de la classe Parent (AbstractController)

        $pokemonUpdateForm->handleRequest($request);
        // le handle request permet de lier le formulaire avec la requête, il recupere les données postées dans la variable (du POST et les stock dans l'Entity)
        // Pour recuperer une instance de request Symfony vient instancier pour nous, on met request en param

        if ($pokemonUpdateForm->isSubmitted() && $pokemonUpdateForm->isValid()) {
            // si le formulaire est submit et qu il est valide (de type Post) alors, le handlerequest sait si cela a été posté ou pas
            $entityManager->persist($pokemon); // preparation : on prepare la requete Sql
            $entityManager->flush(); // execute : on execute la requete préparée
        }
        $pokemonUpdateFormView = $pokemonUpdateForm->createView() ;
        //
        return $this->render('Page/pokemon-update-form.html.twig', [
            'pokemon' => $pokemon,
            'pokemonUpdateForm' => $pokemonUpdateFormView
//j envoie en variable twig le formulaire a afficher (deuxieme methode d affichage)

        ]);

    }
}





















