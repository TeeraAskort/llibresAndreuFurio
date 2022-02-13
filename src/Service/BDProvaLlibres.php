<?php

namespace App\Service;

class BDProvaLlibres
{
    private $llibres = array(
        array('isbn' => "A111B3", 'titol' => "El joc d'Ender", 'autor' => "Orson Scott Card", "pagines" => 350, 'imatge' => "ender.jpg"),
        array('isbn' => "16703-55-5", 'titol' => "Qué torpe eres, ueno", 'autor' => "tugeneko", "pagines" => 200, 'imatge' => "ueno.jpg"),
        array('isbn' => "18419-16-4", 'titol' => "acabé hecha un trapo huyendo de la realidad", 'autor' => "kabi nagata", "pagines" => 200, 'imatge' => "trapo.jpg"),
        array('isbn' => "18222-20-7", 'titol' => "Rastros de sangre 2", 'autor' => "Shuzo Oshimi", "pagines" => 200, 'imatge' => "sangre.jpg"),
    );

    function getLlibres()
    {
        return $this->llibres;
    }
}
