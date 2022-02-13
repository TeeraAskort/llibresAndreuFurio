<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IniciController extends AbstractController
{
    private $llibres;

    public function __construct($dades)
    {
        $this->llibres = $dades->getLlibres();
    }

    /**
     * @Route("/", name="inici")
     */
    public function inici()
    {
        return $this->render('inici.html.twig', array('llibres' => $this->llibres));
    }
}
