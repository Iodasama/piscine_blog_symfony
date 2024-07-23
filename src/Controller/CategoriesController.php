<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'list_categories')]
    public function listCategories()
    {
        $categories = [
            'Red', 'Green', 'Blue', 'Yellow', 'Gold', 'Silver', 'Crystal'
        ];

        $html = $this->renderView('Page/categories.html.twig', ['categories' => $categories]); // $html = $this->renderView   Ne pas oublier c est renderView ici

        return new Response ($html, 200); // pour me retourner un status 200
    }
}