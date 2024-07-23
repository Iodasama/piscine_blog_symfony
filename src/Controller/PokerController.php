<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class PokerController extends AbstractController
{
    #[Route('/poker', name: 'poker')]
    public function poker()
    {
        $request = Request::createFromGlobals();

if (!$request->query->has('age')) {

    return $this->render('Page/poker_form.html.twig');}

else {

    $age=$request->query->get('age');

    if ($age>=18) {

            return $this->render('Page/poker_welcome.html.twig');}

            else {

                return $this->render('Page/get_out_MF.html.twig');}

}




    }
}