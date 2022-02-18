<?php

namespace App\Entity;

use App\Repository\LlibreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LlibreRepository::class)]
class Llibre
{

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotBlank]
    private $isbn;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $titol;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    private $autor;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(100, null, "La quantitat de págines ha de ser major de 100")]
    private $pagines;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $imatge;

    #[ORM\ManyToOne(targetEntity: Editorial::class)]
    private $editorial;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getTitol(): ?string
    {
        return $this->titol;
    }

    public function setTitol(string $titol): self
    {
        $this->titol = $titol;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getPagines(): ?int
    {
        return $this->pagines;
    }

    public function setPagines(int $pagines): self
    {
        $this->pagines = $pagines;

        return $this;
    }

    public function getImatge(): ?string
    {
        return $this->imatge;
    }

    public function setImatge(string $imatge): self
    {
        $this->imatge = $imatge;

        return $this;
    }

    public function getEditorial(): ?Editorial
    {
        return $this->editorial;
    }

    public function setEditorial(?Editorial $editorial): self
    {
        $this->editorial = $editorial;

        return $this;
    }
}
