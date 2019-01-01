<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index(CategorieRepository $repo)
    {
        return $this->render('front/index.html.twig', [
            'categories' => $repo->findAll()
        ]);
    }


    /**
     * @Route("/cat/{id}", name="afficher_produits")
     */
    public function afficheProduits(Categorie $categorie, ProduitRepository $repo)
    {
        $produits = $repo->createQueryBuilder('prd')
            ->innerJoin('prd.categories', 'cat')
            ->where('cat.id = :cat')
            ->setParameter('cat', $categorie->getId())
            ->getQuery()->getResult();

        return $this->render('front/produits.html.twig', [
            'categorie' => $categorie,
            'produits' => $produits

        ]);
    }


    /**
     * @Route("/prd/{id}", name="affichier_produit")
     */
    public function afficheProduit(Produit $produit)
    {
        return $this->render('front/produit.html.twig', [
            'produit' => $produit
        ]);
    }





}
