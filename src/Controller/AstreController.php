<?php

namespace App\Controller;

use App\Entity\Astre;
use App\Form\AstreType;
use App\Repository\AstreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/astre")
 */
class AstreController extends AbstractController
{
    /**
     * @Route("/", name="astre_index", methods={"GET"})
     */
    //affichage de tout les astres
    public function index(AstreRepository $astreRepository): Response
    {
        $content = new ArrayCollection();
        $url= 'https://api.nasa.gov/planetary/apod?api_key=eATCiSkREIRO5kjfvmdgzLkt2QGOuy2Lqt3kncpi';
        $client = HttpClient::create(['http_version' => '2.0']);
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            $content = $response->toArray();
            if($statusCode == 200){
                dump($content);
            }
        return $this->render('astre/index.html.twig', [
            'astres' => $astreRepository->findAll(),
            'imgDuJour' => $content
        ]);
    }
     /**
     * @Route("/api_getAstre", name="api_getAstre")
     */
    public function ApiGetAstre( AstreRepository $astreRepository){//recuperation d'un premier jeu de données
        $astres = ['themisto','metis','thebe','phobos','deimos','europe','ganymede','callisto','jupiter','venus','mars','uranus','lune','terre','pluton'];
        foreach ($astres as $value) { //interrogation API pour recuperer le infos
            $url = 'https://api.le-systeme-solaire.net/rest/bodies/' . $value;
            $client = HttpClient::create(['http_version' => '2.0']);
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            $content = $response->toArray();
            if($statusCode == 200){
                        $astre = new Astre();
                        $astre->setName($content["id"])
                                ->setPerihelion($content["perihelion"])
                                ->setMass($content["mass"]["massValue"])
                                ->setVolume($content["vol"]["volValue"]);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($astre);    
                        }
        }  
        $entityManager->flush();
        return $this->redirectToRoute('astre_index');   
    }
    /**
     * @Route("/api_getOneAstre", name="api_getOneAstre")
     */
    //intérrogation de l'api pour recup par nom de l'astre
    public function ApiGetOneAstre(Request $request , AstreRepository $astreRepository){
         //interrogation API pour recuperer le infos
        $content = new ArrayCollection();
        $name=$request->query->get("name");
        $url = 'https://api.le-systeme-solaire.net/rest/bodies/' . $name;
        $client = HttpClient::create(['http_version' => '2.0']);
        $response = $client->request('GET', $url);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        if($statusCode == 200){

                    $astre = new Astre();
                    $astre->setName($content["id"])
                            ->setPerihelion($content["perihelion"])
                            ->setMass($content["mass"]["massValue"])
                            ->setVolume($content["vol"]["volValue"]);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($astre);    
                    $entityManager->flush();
        }
        
        return $this->redirectToRoute('astre_index');   
    }
    /**
     * @Route("/image/{id}", name="astre_detail", methods={"GET","POST"})
     */
    //fonction qui va rechercher toute les images publique de la NASA par le nom de l'astre
    public function detail(Astre $astre, Request $request, AstreRepository $astreRepository): Response
    {
        $imagesTab = new ArrayCollection();
        $name = $astre->getName();
        $url = 'https://images-api.nasa.gov/search?q='.$name;
        $client = HttpClient::create(['http_version' => '2.0']);
        $response = $client->request('GET', $url);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        if($statusCode == 200){
            foreach($content["collection"]["items"] as $value){
                $imagesTab[]=$value["links"][0]["href"];//recupération des liens
            }
        }   
        dump($imagesTab);
        return $this->render('astre/image.html.twig', [
            'astre' => $astre,
            'images' => $imagesTab,
        ]);
    }
    /**
     * @Route("/new", name="astre_new", methods={"GET","POST"})
     */
    //ajout manuel d'un astre
    public function new(Request $request): Response
    {
        $astre = new Astre();
        $form = $this->createForm(AstreType::class, $astre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($astre);
            $entityManager->flush();

            return $this->redirectToRoute('astre_index');
        }

        return $this->render('astre/new.html.twig', [
            'astre' => $astre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="astre_show", methods={"GET"})
     */
    //détails et info de l'astre
    public function show(Astre $astre): Response
    {
        
        return $this->render('astre/show.html.twig', [
            'astre' => $astre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="astre_edit", methods={"GET","POST"})
     */
    //modification de l'astre
    public function edit(Request $request, Astre $astre): Response
    {
        $form = $this->createForm(AstreType::class, $astre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('astre_index');
        }

        return $this->render('astre/edit.html.twig', [
            'astre' => $astre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="astre_delete", methods={"DELETE"})
     */
    //suppression de l'astre
    public function delete(Request $request, Astre $astre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$astre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($astre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('astre_index');
    }

   
}
