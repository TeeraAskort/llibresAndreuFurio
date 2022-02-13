<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LlibreController extends AbstractController
{
    private $llibres;

    public function __construct($dades)
    {
        $this->llibres = $dades->getLlibres();
    }

    /**
     * @Route("/llibre/{isbn}", name="fitxa_llibre")
     */
    public function fitxa($isbn)
    {

        $llibre = null;
        foreach ($this->llibres as $book) {
            if ($book['isbn'] == $isbn) {
                $llibre = $book;
            }
        }

        return $this->render('fitxa_llibre.html.twig', array('llibre' => $llibre));
    }
}
