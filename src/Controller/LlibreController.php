<?php

namespace App\Controller;

use App\Entity\Editorial;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Llibre;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class LlibreController extends AbstractController
{
    private $llibres;
    private $dades;

    public function __construct($dades)
    {
        $this->dades = $dades;
        $this->llibres = $dades->getLlibres();
    }

    /**
     * @Route("/llibre/inserir", name="inserir")
     */
    public function inserir(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $llibre = new Llibre();
        $llibre->setIsbn('7777SSSS');
        $llibre->setTitol('Noruega');
        $llibre->setAutor('Rafa Lahuerta');
        $llibre->setPagines(387);
        $llibre->setImatge('llibre.png');
        $entityManager->persist($llibre);
        // $entityManager->flush();
        // return new Response("Llibre inserit amb isbn " . $llibre->getIsbn());
        $dorohedoro = new Llibre();
        $dorohedoro->setIsbn('1111AAA');
        $dorohedoro->setTitol('Dorohedoro');
        $dorohedoro->setAutor('Q-Hayashida');
        $dorohedoro->setPagines(170);
        $dorohedoro->setImatge('dorohedoro.jpg');
        $entityManager->persist($dorohedoro);

        $boys = new Llibre();
        $boys->setIsbn('2222BBB');
        $boys->setTitol("20th Century Boys");
        $boys->setAutor('Naoki Urasawa');
        $boys->setPagines('208');
        $boys->setImatge('boys.jpg');
        $entityManager->persist($boys);

        $chunyan = new Llibre();
        $chunyan->setIsbn('3333CCC');
        $chunyan->setTitol('Chunyan, La Nueva Leyenda');
        $chunyan->setAutor('CLAMP');
        $chunyan->setPagines('224');
        $chunyan->setImatge('chunyan.jpg');
        $entityManager->persist($chunyan);

        try {
            $entityManager->flush();
            return new Response("Inserits llibres amb isbn " . $dorohedoro->getIsbn() . " " . $boys->getIsbn() . " " . $chunyan->getIsbn());
        } catch (\Exception $e) {
            return new Response("Error inserint llibres amb isbn " . $dorohedoro->getIsbn() . " " . $boys->getIsbn() . " " . $chunyan->getIsbn());
        }
    }

    /**
     * @Route("/llibre/pagines/{pagines}", name="filtrar_pagines")
     */
    public function filtrar_pagines($pagines)
    {
        return $this->render('llista-major.html.twig', array('llibres' => $this->dades->getLlibresGreaterThanPagines($pagines), 'pagines' => $pagines));
    }

    /**
     * @Route("/llibre/inserirambeditorial", name="inserirambeditorial")
     */
    public function inserir_amb_editorial(ManagerRegistry $doctrine)
    {
        $EdRepository = $doctrine->getRepository(Editorial::class);
        $entityManager = $doctrine->getManager();
        $editorial = $EdRepository->findOneBy(['nom' => 'Bromera']);
        if ($editorial == null) {
            $editorial = new Editorial();
            $editorial->setNom("Bromera");
            $entityManager->persist($editorial);
            $entityManager->flush();
            $editorial = $EdRepository->findOneBy(['nom' => 'Bromera']);
        }
        $llibre = new Llibre();
        $llibre->setIsbn('8888TTT');
        $llibre->setTitol('Nuestra Salvaje Juventud');
        $llibre->setPagines(200);
        $llibre->setImatge('salvaje.jpg');
        $llibre->setAutor('Mari Okada, Nao Emoto');
        $llibre->setEditorial($editorial);
        $entityManager->persist($llibre);
        try {
            $entityManager->flush();
            return new Response("Llibre amb editorial inserit correctament, isbn: " . $llibre->getIsbn());
        } catch (\Exception $e) {
            return new Response("Error inserint llibre amb editorial, isbn: " . $llibre->getIsbn());
        }
    }

    /**
     * @Route("/llibre/{isbn}", name="fitxa_llibre")
     */
    public function fitxa($isbn)
    {

        $llibre = null;
        foreach ($this->llibres as $book) {
            if ($book->getIsbn() == $isbn) {
                $llibre = $book;
            }
        }

        return $this->render('fitxa_llibre.html.twig', array('llibre' => $llibre));
    }
}
