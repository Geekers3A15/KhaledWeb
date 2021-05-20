<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Form\CompetitionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CompetitionController extends AbstractController
{
    /**
     * @Route("/nvm", name="cc")
     */
    public function index(): Response
    {
        return $this->render('competition/index.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }
    /**
     * @Route("/competition", name="compD", methods={"GET", "POST"})
     */
    public function listF( Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Competition::class);
        $items = $repository->findAll();


        return $this->render('competition/index.html.twig',['competitions'=> $items]);
    }
    /**
     * @Route("/Ahome", name="displayb", methods={"GET", "POST"})
     */
    public function list( Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Competition::class);
        $items = $repository->findAll();


        return $this->render('competition/home.html.twig',['competitions'=> $items]);
    }

    /**
     * @Route("/add", name="addcomp")
     */
    public function add(Request $request)
    {
        $comp = new Competition();
        $form = $this->createForm(CompetitionType::class, $comp);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comp);
            $entityManager->flush();
            return $this->redirectToRoute('displayb');
        }
        return $this->render('competition/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edit/{id}", name="editC")
     * @ParamConverter("comp", class="App:Competition")
     */
    public function edit(Request $request, $comp)
    {
        $form = $this->createForm(CompetitionType::class,$comp);
        $form->handleRequest($request);
        $data = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $comp = $em->getRepository(Competition::class)->findOneBy(array('id' => $data->getId()));
        if ($form->isSubmitted()) {

            $em->persist($comp);
            $em->flush();
            return $this->redirectToRoute('displayb');
        }

        return $this->render('competition/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("delete/{id}", name="deleteC")
     */
    public function delete(Competition $comp)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($comp);
        $em->flush();
        return $this->redirectToRoute('displayb');
    }


}
