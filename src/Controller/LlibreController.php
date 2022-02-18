<?php

namespace App\Controller;

use App\Entity\Editorial;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Llibre;
use App\Form\LlibreEditaType;
use App\Form\LlibreNouType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/llibre/nou", name="llibre_nou")
     */
    public function nou(Request $request, ManagerRegistry $doctrine)
    {
        $llibre = new Llibre();
        $formulari = $this->createForm(LlibreNouType::class, $llibre);

        $formulari->handleRequest($request);
        if ($formulari->isSubmitted() && $formulari->isValid()) {
            $fitxer = $formulari->get('imatge')->getData();
            if ($fitxer) { // si s’ha indicat un fitxer al formulari
                $nomFitxer = $fitxer->getClientOriginalName();
                //ruta a la carpeta de les imatges, relativa a index.php
                //aquest directori ha de tindre permisos d’escriptura
                $directori = $this->getParameter('kernel.project_dir') . "/public/imgs/";
                try {
                    $fitxer->move($directori, $nomFitxer);
                } catch (FileException $e) {
                    return $this->render('nou.html.twig', array('formulari' => $formulari->createView(), 'imatge' => null, 'error' => "No s'ha pogut pujar l'imatge"));
                }
                $llibre->setImatge($nomFitxer); // valor del camp imatge

            } else {
                $llibre->setImatge('llibre.png'); //no hi ha fitxer, imatge per defecte
            }
            $llibre->setIsbn($formulari->get('isbn')->getData());
            $llibre->setTitol($formulari->get('titol')->getData());
            $llibre->setAutor($formulari->get('autor')->getData());
            $llibre->setPagines($formulari->get('pagines')->getData());
            $llibre->setEditorial($formulari->get('editorial')->getData());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($llibre);
            try {
                $entityManager->flush();
                return $this->redirectToRoute('inici');
            } catch (\Exception $e) {
                if ($fitxer) {
                    $nomFitxer = $fitxer->getClientOriginalName();
                    $directori = $this->getParameter('kernel.project_dir') . "/public/imgs/";
                    if (is_file($directori . "/" . $nomFitxer)) {
                        unlink($directori . "/" . $nomFitxer);
                    }
                }
                return $this->render('nou.html.twig', array('formulari' => $formulari->createView(), 'imatge' => null, 'error' => "No s'ha pogut inserir el llibre duplicat"));
            }
        }
        return $this->render('nou.html.twig', array('formulari' => $formulari->createView(), 'imatge' => null, 'error' => null));
    }

    /**
     * @Route("/llibre/editar/{isbn}", name="editar_llibre")
     */
    public function editar_llibre($isbn, ManagerRegistry $doctrine, Request $request)
    {
        $repository = $doctrine->getRepository(Llibre::class);
        $llibre = $repository->find($isbn);
        $formulari =
            $this->createForm(LlibreEditaType::class, $llibre);

        $formulari->handleRequest($request);

        if ($formulari->isSubmitted() && $formulari->isValid()) {
            $fitxer = $formulari->get('imatge')->getData();
            if ($fitxer) { // si s’ha indicat un fitxer al formulari
                $nomFitxer = $fitxer->getClientOriginalName();
                //ruta a la carpeta de les imatges, relativa a index.php
                //aquest directori ha de tindre permisos d’escriptura
                $directori = $this->getParameter('kernel.project_dir') . "/public/imgs/";
                try {
                    $fitxer->move($directori, $nomFitxer);
                    if ($llibre->getImatge() != "llibre.png" && is_file($directori . "/" . $llibre->getImatge())) {
                        unlink($directori . "/" . $llibre->getImatge());
                    }
                } catch (FileException $e) {
                    return $this->render('nou.html.twig', array('formulari' => $formulari->createView(), 'imatge' => null, 'error' => "No s'ha pogut pujar l'imatge"));
                }
                $llibre->setImatge($nomFitxer); // valor del camp imatge
            }
            $entityManager = $doctrine->getManager();

            $llibre->setIsbn($formulari->get('isbn')->getData());
            $llibre->setTitol($formulari->get('titol')->getData());
            $llibre->setAutor($formulari->get('autor')->getData());
            $llibre->setPagines($formulari->get('pagines')->getData());
            $llibre->setEditorial($formulari->get('editorial')->getData());
            // $entityManager->persist($llibre);
            try {
                $entityManager->flush();
                return $this->redirectToRoute('inici');
            } catch (\Exception $e) {
                return $this->render('nou.html.twig', array('formulari' => $formulari->createView(), 'imatge' => null, 'error' => "No s'ha pogut inserir el llibre duplicat"));
            }
        }

        return $this->render('nou.html.twig', array('formulari' => $formulari->createView(), 'imatge' => $llibre->getImatge(), 'error' => null));
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
