<?php 

namespace App\Controller; // on remplace les require par namespace ca reprend le chemin de par ou est passée la Classe  // cad un chemin pour identifer la classe




use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // php storm va chercher directement avec use pour plus de facilité
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// on cree la Classe du meme nom que le fichier afin que le Framework s y retrouve mieux et on respecte la convention une Classe/Fichier
// on etend la Classe extends, AbstractController est dans Vendor pret a l emploi, pour recuperer tout ce qu il y a dans le Parent sauf ce qui sera mis en private
class IndexController extends AbstractController //on etend la classe Abstratccontroller qui permet d utiliser les fonctions utilitaires pour que symfony fasse le require de ces classes
{
    #[Route('/', name: 'app_IndexController')] // je cree une nouvelle route et une page ('/') qui affiche // # annotation equivalent de if comme dans index.php avant, permet de creer une nouvelle route cad une nouvelle page sur notre appli quand l url est appelee cela execute automatiquement la methode definit sous la route
    public function index () {  

        var_dump('value:"hello World"');die; // je fais un var_dump pour recuperer un affichage "hello World
    } 

}