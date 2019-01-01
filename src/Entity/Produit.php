<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descpCourt;

    /**
     * @ORM\Column(type="text")
     */
    private $descpLong;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageP;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageS1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageS2;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", inversedBy="produits")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="produit")
     */
    private $avis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitCommande", mappedBy="produit")
     */
    private $produitCommandes;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->produitCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescpCourt(): ?string
    {
        return $this->descpCourt;
    }

    public function setDescpCourt(string $descpCourt): self
    {
        $this->descpCourt = $descpCourt;

        return $this;
    }

    public function getDescpLong(): ?string
    {
        return $this->descpLong;
    }

    public function setDescpLong(string $descpLong): self
    {
        $this->descpLong = $descpLong;

        return $this;
    }

    public function getImageP(): ?string
    {
        return $this->imageP;
    }

    public function setImageP(string $imageP): self
    {
        $this->imageP = $imageP;

        return $this;
    }

    public function getImageS1(): ?string
    {
        return $this->imageS1;
    }

    public function setImageS1(?string $imageS1): self
    {
        $this->imageS1 = $imageS1;

        return $this;
    }

    public function getImageS2(): ?string
    {
        return $this->imageS2;
    }

    public function setImageS2(?string $imageS2): self
    {
        $this->imageS2 = $imageS2;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setProduit($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->contains($avi)) {
            $this->avis->removeElement($avi);
            // set the owning side to null (unless already changed)
            if ($avi->getProduit() === $this) {
                $avi->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProduitCommande[]
     */
    public function getProduitCommandes(): Collection
    {
        return $this->produitCommandes;
    }

    public function addProduitCommande(ProduitCommande $produitCommande): self
    {
        if (!$this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes[] = $produitCommande;
            $produitCommande->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes->removeElement($produitCommande);
            // set the owning side to null (unless already changed)
            if ($produitCommande->getProduit() === $this) {
                $produitCommande->setProduit(null);
            }
        }

        return $this;
    }
}
