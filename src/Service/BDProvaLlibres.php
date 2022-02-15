<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Llibre;
use App\Repository\LlibreRepository;

class BDProvaLlibres
{
    private $repository;

    public function __construct(LlibreRepository $repository)
    {
        $this->repository = $repository;
    }

    function getLlibres()
    {
        return $this->repository->findAll();
    }

    function getLlibresGreaterThanPagines($pagines)
    {
        return $this->repository->findByPaginesGreaterThan($pagines);
    }
}
