<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\InquiryAssign;
use AppBundle\Form\InquiryAssignType;

/**
 * InquiryAssign controller.
 *
 * @Route("/inquiryassign")
 */
class InquiryAssignController extends Controller
{
    /**
     * Lists all InquiryAssign entities.
     *
     * @Route("/", name="inquiryassign_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $inquiryAssigns = $em->getRepository('AppBundle:InquiryAssign')->findAll();

        return $this->render('inquiryassign/index.html.twig', array(
            'inquiryAssigns' => $inquiryAssigns,
        ));
    }

    /**
     * Creates a new InquiryAssign entity.
     *
     * @Route("/new", name="inquiryassign_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $inquiryAssign = new InquiryAssign();
        $form = $this->createForm('AppBundle\Form\InquiryAssignType', $inquiryAssign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inquiryAssign);
            $em->flush();

            return $this->redirectToRoute('inquiryassign_show', array('id' => $inquiryAssign->getId()));
        }

        return $this->render('inquiryassign/new.html.twig', array(
            'inquiryAssign' => $inquiryAssign,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a InquiryAssign entity.
     *
     * @Route("/{id}", name="inquiryassign_show")
     * @Method("GET")
     */
    public function showAction(InquiryAssign $inquiryAssign)
    {
        $deleteForm = $this->createDeleteForm($inquiryAssign);

        return $this->render('inquiryassign/show.html.twig', array(
            'inquiryAssign' => $inquiryAssign,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing InquiryAssign entity.
     *
     * @Route("/{id}/edit", name="inquiryassign_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, InquiryAssign $inquiryAssign)
    {
        $deleteForm = $this->createDeleteForm($inquiryAssign);
        $editForm = $this->createForm('AppBundle\Form\InquiryAssignType', $inquiryAssign);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inquiryAssign);
            $em->flush();

            return $this->redirectToRoute('inquiryassign_edit', array('id' => $inquiryAssign->getId()));
        }

        return $this->render('inquiryassign/edit.html.twig', array(
            'inquiryAssign' => $inquiryAssign,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a InquiryAssign entity.
     *
     * @Route("/{id}", name="inquiryassign_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, InquiryAssign $inquiryAssign)
    {
        $form = $this->createDeleteForm($inquiryAssign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($inquiryAssign);
            $em->flush();
        }

        return $this->redirectToRoute('inquiryassign_index');
    }

    /**
     * Creates a form to delete a InquiryAssign entity.
     *
     * @param InquiryAssign $inquiryAssign The InquiryAssign entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(InquiryAssign $inquiryAssign)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inquiryassign_delete', array('id' => $inquiryAssign->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
