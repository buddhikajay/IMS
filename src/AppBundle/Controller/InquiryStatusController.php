<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\InquiryStatus;
use AppBundle\Form\InquiryStatusType;

/**
 * InquiryStatus controller.
 *
 * @Route("/inquirystatus")
 */
class InquiryStatusController extends Controller
{
    /**
     * Lists all InquiryStatus entities.
     *
     * @Route("/", name="inquirystatus_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $inquiryStatuses = $em->getRepository('AppBundle:InquiryStatus')->findAll();

        return $this->render('inquirystatus/index.html.twig', array(
            'inquiryStatuses' => $inquiryStatuses,
        ));
    }

    /**
     * Creates a new InquiryStatus entity.
     *
     * @Route("/new", name="inquirystatus_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $inquiryStatus = new InquiryStatus();
        $form = $this->createForm('AppBundle\Form\InquiryStatusType', $inquiryStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inquiryStatus);
            $em->flush();

            return $this->redirectToRoute('inquirystatus_show', array('id' => $inquiryStatus->getId()));
        }

        return $this->render('inquirystatus/new.html.twig', array(
            'inquiryStatus' => $inquiryStatus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a InquiryStatus entity.
     *
     * @Route("/{id}", name="inquirystatus_show")
     * @Method("GET")
     */
    public function showAction(InquiryStatus $inquiryStatus)
    {
        $deleteForm = $this->createDeleteForm($inquiryStatus);

        return $this->render('inquirystatus/show.html.twig', array(
            'inquiryStatus' => $inquiryStatus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing InquiryStatus entity.
     *
     * @Route("/{id}/edit", name="inquirystatus_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, InquiryStatus $inquiryStatus)
    {
        $deleteForm = $this->createDeleteForm($inquiryStatus);
        $editForm = $this->createForm('AppBundle\Form\InquiryStatusType', $inquiryStatus);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inquiryStatus);
            $em->flush();

            return $this->redirectToRoute('inquirystatus_edit', array('id' => $inquiryStatus->getId()));
        }

        return $this->render('inquirystatus/edit.html.twig', array(
            'inquiryStatus' => $inquiryStatus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a InquiryStatus entity.
     *
     * @Route("/{id}", name="inquirystatus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, InquiryStatus $inquiryStatus)
    {
        $form = $this->createDeleteForm($inquiryStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($inquiryStatus);
            $em->flush();
        }

        return $this->redirectToRoute('inquirystatus_index');
    }

    /**
     * Creates a form to delete a InquiryStatus entity.
     *
     * @param InquiryStatus $inquiryStatus The InquiryStatus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(InquiryStatus $inquiryStatus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inquirystatus_delete', array('id' => $inquiryStatus->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
