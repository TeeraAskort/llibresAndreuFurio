<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Jenssegers\Date\Date;

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
        $usuari = $this->getUser();
        Date::setLocale('ca_ES');
        $ara = Date::now();
        $data = $ara->format('l, d F Y') . ", carregat a les " . $ara->format('H:i:s');
        return $this->render('inici.html.twig', array('llibres' => $this->llibres, 'data' => $data));
    }
}
