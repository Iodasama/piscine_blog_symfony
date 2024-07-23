<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response; // pour pouvoir obtenir Reponse Http, 200 ici
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class categoriesController extends AbstractController
{
    #[Route('/categories', name: 'list_categories')]
    public function listCategories()
    {
        $categories = [
            'Red', 'Green', 'Blue', 'Yellow', 'Gold', 'Silver', 'Crystal'
        ];

        $html = $this->render('Page/categories.html.twig', ['categories' => $categories]);

        return new Response ($html, status: 200); // pour me retourner un status 200
    }
}