<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LlibreController
{
    /**
     * @Route("/llibre/{isbn}", name="fitxa_llibre")
     */
    public function fitxa($isbn)
    {
        $llibres = array(
            array('isbn' => "A111B3", 'titol' => "El joc d'Ender", 'autor' => "Orson Scott Card", "pagines" => 350),
            array('isbn' => "16703-55-5", 'titol' => "Qué torpe eres, ueno", 'autor' => "tugeneko", "pagines" => 200),
            array('isbn' => "18419-16-4", 'titol' => "acabé hecha un trapo huyendo de la realidad", 'autor' => "kabi nagata", "pagines" => 200),
            array('isbn' => "18222-20-7", 'titol' => "Rastros de sangre 2", 'autor' => "Shuzo Oshimi", "pagines" => 200),
        );
        $llibre = null;
        foreach ($llibres as $book) {
            if ($book['isbn'] == $isbn) {
                $llibre = $book;
            }
        }
        if ($llibre != null) {
            return new Response("ISBN: " . $llibre['isbn'] . ", Titol: " . $llibre['titol'] . ", Autor: " . $llibre['autor'] . ", Pàgines: " . $llibre['pagines']);
        } else {
            return new Response("Llibre no trobat");
        }
    }
}
