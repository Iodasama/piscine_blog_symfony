<?php

declare(strict_types=1);
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class ProductController extends AbstractController
{

    private $products;
    public function __construct()
    {
        $this-> products = $products = [
            [
                'id' => 1,
                'title' => 'Playstation 5',
                'price' => 499.99,
                'price_reduction' => 0,
                'image' => 'https://gmedia.playstation.com/is/image/SIEPDC/ps5-product-thumbnail-01-en-14sep21',
                'categories' => ['console', 'sony']
            ],
            [
                'id' => 2,
                'title' => 'Xbox Series X',
                'price' => 499.99,
                'price_reduction' => 0,
                'image' => 'https://m.media-amazon.com/images/I/61wo73JnhyL.jpg',
                'categories' => ['console', 'microsoft']
            ],
            [
                'id' => 3,
                'title' => 'Nintendo Switch',
                'price' => 299.99,
                'price_reduction' => 0,
                'image' => 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/en_US/products/hardware/nintendo-switch-red-blue/110478-nintendo-switch-neon-blue-neon-red-front-screen-on-1200x675',
                'categories' => ['console', 'nintendo']
            ],
            [
                'id' => 4,
                'title' => 'Playstation 4',
                'price' => 299.99,
                'price_reduction' => 199.99,
                'image' => 'data:image/jpeg;base64,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',
                'categories' => ['console', 'sony']
            ],
            [
                'id' => 5,
                'title' => 'Xbox One',
                'price' => 299.99,
                'price_reduction' => 199.99,
                'image' => 'data:image/jpeg;base64,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',
                'categories' => ['console', 'microsoft']
            ],
        ];


    }
    #[Route('/products', name: 'list_products')]
    public function listProducts()
    {

        return $this->render('Page/products.html.twig', ['products' => $this->products]);

    }







    #[Route('/product_show/{idProduct}', name: 'show_product')]
    public function showProduct($idProduct, Request $request):Response

    {
//        $request= new Request($_GET, $_POST, etc);
//        $request = Request::createFromGlobals();
      //  $idProduct = $request->query->get('id');



        $productFound = null;

        foreach ($this->products as $product) {
            if ($product['id'] === (int)$idProduct) {
                $productFound = $product;
            }

        }

        return $this->render('Page/product_show.html.twig', [
            'product' => $productFound
        ]);
    }
}
