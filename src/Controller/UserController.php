<?php

namespace App\Controller;

use App\Entity\Usuari;
use App\Form\UsuariEditaType;
use App\Form\UsuariNouType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/usuari', name: 'usuari')]
    public function usuaris(ManagerRegistry $doctrine)
    {
        $URepository = $doctrine->getRepository(Usuari::class);
        $usuaris = $URepository->findAll();
        return $this->render('usuari.html.twig', array('usuaris' => $usuaris));
    }

    #[Route('/usuari/nou', name: 'usuari_nou')]
    public function usuari_nou(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine, Request $request)
    {
        $usuari = new Usuari();
        $formulari = $this->createForm(UsuariNouType::class, $usuari);

        $formulari->handleRequest($request);
        if ($formulari->isSubmitted() && $formulari->isValid()) {
            $usuari->setUsername($formulari->get('username')->getData());
            $roles = [];
            $roles[] = $formulari->get('roles')->getData();
            $usuari->setRoles($roles);
            $password = $formulari->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($usuari, $password);
            $usuari->setPassword($hashedPassword);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($usuari);
            try {
                $entityManager->flush();
                return $this->redirectToRoute('usuari');
            } catch (\Exception $e) {
                return $this->render('usuari-nou.html.twig', array('formulari' => $formulari->createView(), 'error' => "No s'ha pogut inserir l'usuari"));
            }
        }

        return $this->render('usuari-nou.html.twig', array('formulari' => $formulari->createView(), 'error' => null));
    }

    #[Route('/usuari/eliminar/{id}', name: 'eliminar_usuari')]
    public function elimina_usuari($id, ManagerRegistry $doctrine)
    {
        $URepository = $doctrine->getRepository(Usuari::class);
        $entityManager = $doctrine->getManager();
        $usuari = $URepository->find($id);
        if ($usuari != null) {
            $entityManager->remove($usuari);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuari');
    }

    #[Route('/usuari/editar/{id}', name: 'editar_usuari')]
    public function editar_usuari($id, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine, Request $request)
    {
        $URepository = $doctrine->getRepository(Usuari::class);
        $usuari = $URepository->find($id);
        $formulari = $this->createForm(UsuariEditaType::class, $usuari);

        $formulari->handleRequest($request);
        if ($formulari->isSubmitted() && $formulari->isValid()) {
            $usuari->setUsername($formulari->get('username')->getData());
            $password = $formulari->get('password')->getData();
            if ($password != null) {
                $hashedPassword = $passwordHasher->hashPassword($usuari, $password);
                $usuari->setPassword($hashedPassword);
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($usuari);
            try {
                $entityManager->flush();
                return $this->redirectToRoute('usuari');
            } catch (\Exception $e) {
                return $this->render('usuari-nou.html.twig', array('formulari' => $formulari->createView(), 'error' => "No s'ha pogut inserir l'usuari"));
            }
        }

        return $this->render('usuari-nou.html.twig', array('formulari' => $formulari->createView(), 'error' => null));
    }
}
