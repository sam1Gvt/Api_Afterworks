<?php

namespace App\Controller;

use App\Entity\PriseEnChargeCommande;
use App\Entity\ProduitCommande;
use App\Repository\CommandeRepository;
use App\Entity\Commande;

use App\Repository\PriseEnChargeCommandeRepository;
use App\Repository\ProduitCommandeRepository;
use App\Repository\ProduitRepository;
use App\Repository\StatutCommandeRepository;
use Couchbase\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class AfterworksMobileController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;

    private CommandeRepository $commandeRepository;
    private StatutCommandeRepository $statutCommandeRepository;
    private ProduitCommandeRepository $produitCommandeRepository;
    private PriseEnChargeCommandeRepository $priseEnChargeCommandeRepository;
    private ProduitRepository $produitRepository;

    // Injection de dépendance
    public function __construct(SerializerInterface $serializer,
                                ValidatorInterface $validator,
                                EntityManagerInterface $entityManager,

                                CommandeRepository $commandeRepository,
                                StatutCommandeRepository $statutCommandeRepository,
                                ProduitCommandeRepository $produitCommandeRepository,
                                PriseEnChargeCommandeRepository $priseEnChargeCommandeRepository,
                                ProduitRepository $produitRepository

                               )
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;

        $this->commandeRepository = $commandeRepository;
        $this->statutCommandeRepository = $statutCommandeRepository;
        $this->produitCommandeRepository = $produitCommandeRepository;
        $this->priseEnChargeCommandeRepository = $priseEnChargeCommandeRepository;
        $this->produitRepository = $produitRepository;


    }

    /**
     * @Route("/api/commandes", name="api_commande_getcommandes", methods={"GET"})
     */
    public function getCommandes(): Response
    {
        $commandes = $this->commandeRepository->getAllCommandsWithStatutName();
        $commandesJson = $this->serializer->serialize($commandes,'json');
        return new JsonResponse($commandesJson,Response::HTTP_OK,[] ,true);
    }

    /**
     * @Route("/api/statuts", name="api_statut_getstatuts", methods={"GET"})
     */
    public function getStatuts(): Response
    {
        $statuts = $this->statutCommandeRepository->findAll();
        $statutsJson = $this->serializer->serialize($statuts,'json');
        return new JsonResponse($statutsJson,Response::HTTP_OK,[] ,true);
    }

    /**
     * @Route("/api/statut/command/{id}", name="api_statutCommande_getstatut", methods={"GET"})
     */
    public function getStatutCommand($id): Response
    {
        $statuts = $this->commandeRepository->getStatutCommand($id) ;
        $statutsJson = $this->serializer->serialize($statuts,'json');
        return new JsonResponse($statutsJson,Response::HTTP_OK,[] ,true);
    }

    /**
     * @Route("/api/updateCommande/{id}", name="api_commande_updateCommande", methods={"PUT"})
     */
    public function updateCommande(Request $request, $id): Response
    {

        try {
            $requeteJson = $request->getContent();

            $commande = $this->commandeRepository->find($id);
            // Désérialiser le json
            $commande = $this->serializer->deserialize($requeteJson, Commande::class, "json", ["object_to_populate" => $commande]);

            $errors = $this->validator->validate($commande);
            // Tester si il y a des erreurs
            if (count($errors)) {
                // Il y a erreurs
                // Renvoyer les erreurs sous la forme d'une réponse au format JSON
                $errorsJson = $this->serializer->serialize($errors, 'json');
                return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST, [], true);
            }


            $this->entityManager->flush(); // Envoyer l'ordre INSERT vers la base de données


            // Renvoyer une réponse HTTP
            $commandeJson = $this->serializer->serialize($commande, 'json');
            return new JsonResponse($commandeJson, Response::HTTP_CREATED, [], true);


        } catch (NotEncodableValueException $exception) {
            $error = [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Le JSON envoyé dans la requête n'est pas valide"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error), Response::HTTP_BAD_REQUEST, [], true);
        }
    }

    /**
     * @Route("/api/detailCommande/{id}", name="api_produitCommande_getDetailCommande", methods={"GET"})
     */
    public function getDetailCommande($id): Response
    {
        //$produitsCommande = $this->produitCommandeRepository->findBy(array('idCommande' => $id));
        $produitsCommande = $this->produitCommandeRepository->getProduitsCommand($id);
        $produitsCommandeJson = $this->serializer->serialize($produitsCommande,'json');
        return new JsonResponse($produitsCommandeJson,Response::HTTP_OK,[] ,true);
    }

    /**
     * @Route("/api/priseEnChargeCommande/{id}", name="api_priseEnChargeCommande", methods={"GET"})
     */
    public function getPriseEnChargeCommandeByCommand($id): Response
    {
        $commande = $this->priseEnChargeCommandeRepository->findBy(array('idCommande' => $id));
        $commandeJson = $this->serializer->serialize($commande,'json');
        return new JsonResponse($commandeJson,Response::HTTP_OK,[] ,true);
    }

    /**
     * @Route("/api/createPriseEnChargeCommande", name="api_priseEnChargeCommande_create", methods={"POST"})
     */
    public function createPriseEnChargeCommande(Request $request): Response
    {
        // Récupérer le body de la requête dans lequel se trouve
        // les données au format JSON du nouveau post à insérer
        // Mettre sous surveillance une partie du code
        try {
            $priseEnChargeJSon = $request->getContent();
            // Désérialiser le json en un objet de la classe Utilisateur
            $row = $this->serializer->deserialize($priseEnChargeJSon,PriseEnChargeCommande::class, "json");

            $errors = $this->validator->validate($row);
            // Tester si il y a des erreurs
            if (count($errors)) {
                // Il y a erreurs
                // Renvoyer les erreurs sous la forme d'une réponse au format JSON
                $errorsJson = $this->serializer->serialize($errors, 'json');
                return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST, [], true);
            }
            // Enregistrer l'objet $post dans la base de données
            $this->entityManager->persist($row); // Préparer l'ordre INSERT
            $this->entityManager->flush(); // Envoyer l'ordre INSERT vers la base de données
            // Renvoyer une réponse HTTP
            $postJSon = $this->serializer->serialize($row,'json');
            return new JsonResponse($postJSon,Response::HTTP_CREATED,[],true);
        } // Intercepter une éventuelle exception
        catch (NotEncodableValueException $exception) {
            $error = [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Le JSON envoyé dans la requête n'est pas valide"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_BAD_REQUEST,[],true);
        }
    }
    /**
     * @Route("/api/produit_commande/declinaison/{id}", name="api_produitDeclinaisonCommande_get", methods={"GET"})
     */
    public function getDeclinaisonsProduitCommande($id): Response
    {

        $declinaisons = $this->produitRepository->getDeclinaisonsProduitCommande($id);
        // Tester si le $produit demandé existe
        if (! $declinaisons) {
            // $produit est null
            // Générer une erreur
            $error = [
                "status" => Response::HTTP_NOT_FOUND,
                "message" => "Le produit demandé n'existe pas"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_NOT_FOUND,[],true);
        }
        $produitJson = $this->serializer->serialize($declinaisons,'json');
        return new JsonResponse($produitJson,Response::HTTP_OK,[],true);
    }


}