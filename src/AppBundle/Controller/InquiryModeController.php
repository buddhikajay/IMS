<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\InquiryMode;
use AppBundle\Form\InquiryModeType;

/**
 * InquiryMode controller.
 *
 * @Route("/inquirymode")
 */
class InquiryModeController extends Controller
{
    /**
     * Lists all InquiryMode entities.
     *
     * @Route("/", name="inquirymode_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $inquiryModes = $em->getRepository('AppBundle:InquiryMode')->findAll();

        return $this->render('inquirymode/index.html.twig', array(
            'inquiryModes' => $inquiryModes,
        ));
    }

    /**
     * Creates a new InquiryMode entity.
     *
     * @Route("/new", name="inquirymode_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $inquiryMode = new InquiryMode();
        $form = $this->createForm('AppBundle\Form\InquiryModeType', $inquiryMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inquiryMode);
            $em->flush();

            return $this->redirectToRoute('inquirymode_show', array('id' => $inquiryMode->getId()));
        }

        return $this->render('inquirymode/new.html.twig', array(
            'inquiryMode' => $inquiryMode,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a InquiryMode entity.
     *
     * @Route("/{id}", name="inquirymode_show")
     * @Method("GET")
     */
    public function showAction(InquiryMode $inquiryMode)
    {
        $deleteForm = $this->createDeleteForm($inquiryMode);

        return $this->render('inquirymode/show.html.twig', array(
            'inquiryMode' => $inquiryMode,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing InquiryMode entity.
     *
     * @Route("/{id}/edit", name="inquirymode_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, InquiryMode $inquiryMode)
    {
        $deleteForm = $this->createDeleteForm($inquiryMode);
        $editForm = $this->createForm('AppBundle\Form\InquiryModeType', $inquiryMode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inquiryMode);
            $em->flush();

            return $this->redirectToRoute('inquirymode_edit', array('id' => $inquiryMode->getId()));
        }

        return $this->render('inquirymode/edit.html.twig', array(
            'inquiryMode' => $inquiryMode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a InquiryMode entity.
     *
     * @Route("/{id}", name="inquirymode_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, InquiryMode $inquiryMode)
    {
        $form = $this->createDeleteForm($inquiryMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($inquiryMode);
            $em->flush();
        }

        return $this->redirectToRoute('inquirymode_index');
    }

    /**
     * Creates a form to delete a InquiryMode entity.
     *
     * @param InquiryMode $inquiryMode The InquiryMode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(InquiryMode $inquiryMode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inquirymode_delete', array('id' => $inquiryMode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
