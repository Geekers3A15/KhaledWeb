<?php

namespace App\Controller;


use App\Entity\Participation;
use App\Repository\ParticipationRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Form\ParticipationType;



class ParticipationController extends AbstractController
{

    /**
     * @Route("/sh", name="displays", methods={"GET", "POST"})
     */
    public function list( Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Participation::class);
        $items = $repository->findAll();


        return $this->render('participation/index.html.twig',['participations'=> $items]);
    }

    /**
     * @Route("/pdf", name="displaypdf", methods={"GET"})
     */
    public function pdf( ParticipationRepository $participationRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $participations = $participationRepository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('participation/pdf.html.twig', [
            'participations' => $participations,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);




    }

    /**
     * @Route("/adds", name="addparti")
     */
    public function add(Request $request)
    {
        $part = new Participation();
        $form = $this->createForm(ParticipationType::class, $part);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($part);
            $entityManager->flush();
            return $this->redirectToRoute('compD');
        }
        return $this->render('participation/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function addF(Request $request)
    {
        $part = new Participation();
        $form = $this->createForm(ParticipationType::class, $part);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($part);
            $entityManager->flush();
            return $this->redirectToRoute('compD');
        }
        return $this->render('participation/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/edit/{idComp}/{getIdp();}", name="editx")
     * @ParamConverter("part", class="App:Participation")
     *@ParamConverter("participation", options={"mapping": {"idComp": "idComp"}})
     * @ParamConverter("participation", options={"mapping": {"idp": "idp"}})
     */
    public function edit(Request $request, $part)
    {
        $form = $this->createForm(ParticipationType::class,$part);
        $form->handleRequest($request);
        $data = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $part = $em->getRepository(Participation::class)->findOneBy(array('idp' => $data->getIdp()));
        if ($form->isSubmitted()) {

            $em->persist($part);
            $em->flush();
            return $this->redirectToRoute('displays');
        }

        return $this->render('participation/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("deleteAA/{idp}", name="deleteX")
     */
    public function deleteAA(Participation $part)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($part);
        $em->flush();
        return $this->redirectToRoute('displays');
    }
}
