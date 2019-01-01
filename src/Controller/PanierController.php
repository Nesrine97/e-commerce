<?php
// src/AppBundle/Controller/PanierController.php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Produit;
/**
 * @Route("/panier")
 */
class CartController extends Controller
{
     /**
      * @Route("/add/{id}", name="eshop_add_to_cart")
      */
     function addToPanier(Product $prd) {     	
     	$session = new Session();
     	@$panier = $session->get('sess_panier');
     	@$panier[$prd->getId()] ++ ;
     	$session->set('sess_panier', $panier);
     	
     	// Retrouner à la page précédente
     	$pan  = $prd->getCategorie();
     	return $this->redirectToRoute('categorie', ['id'=> $pan->getId()]);
     }
     // Renvoi le nbr total des produits du panier
     function cartCount() {
     	$session = new Session();
     	$panier = $session->get('sess_panier');
     	$total = 0;
     	if ($panier)
	     	foreach ($panier as $id => $qty) 
	     		$total += $qty;
	     	
     	return new Response($total);
     }
     /**
      * @Route("/", name="eshop_panier")
      */
     function panier() {
     	$session = new Session();
     	$panier = $session->get('sess_panier');
     	$produits = array();
     	$em = $this->getDoctrine()->getManager();
     	$repo = $em->getRepository(Produit::class);
     	$total_ht = 0;
          // Calcul du total HT, mnt TVA et total TTC
          // On ne doit pas laisser la vue faire le calcul
          if ($panier)
          	foreach ($panier as $produit_id => $qty) {
          		$prd = $repo->find($produit_id);
          		$produits[] = $prd;
          		$total_ht += $prd->getPrice() * $qty;
          	}
     	$mnt_tva = $total_ht * 10/100;
     	$total_ttc = $total_ht + $mnt_tva;
     	return $this->render("panier/index.html.twig",
     		[
     			'produits' => $produits,
     			'panier'	 => $panier,
     			'total_ht' => $total_ht,
     			'mnt_tva'  => $mnt_tva,
     			'total_ttc'=> $total_ttc
     		]
     	);
     }
     /**
      * @Route("/panier/supprimer/{id}", name="eshop_remove_from_cart")
      */
     function supp_panier($id) {      
          $session = new Session();
          $panier = $session->get('sess_panier');
          unset($panier[$id]); // Remove item from row
          $session->set('sess_panier', $panier);
          
          // Retrouner au panier
          return $this->redirectToRoute('panier');
     }
     /**
      * @Route("/clear/", name="eshop_clear_cart")
      */
     function clearpanier() {      
          $session = new Session();
          $session->clear('sess_panier');
          // Retrouner au panier
          return $this->redirectToRoute('panier');
     }     
}