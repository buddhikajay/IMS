<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\CustomEmail;
use AppBundle\Form\CustomEmailType;

/**
 * CustomEmail controller.
 *
 * @Route("/customemail")
 */
class CustomEmailController extends Controller
{
    /**
     * Lists all CustomEmail entities.
     *
     * @Route("/", name="customemail_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customEmails = $em->getRepository('AppBundle:CustomEmail')->findAll();

        return $this->render('customemail/index.html.twig', array(
            'customEmails' => $customEmails,
        ));
    }

    /**
     * Creates a new CustomEmail entity.
     *
     * @Route("/new", name="customemail_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $customEmail = new CustomEmail();
        $form = $this->createForm('AppBundle\Form\CustomEmailType', $customEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customEmail);
            $em->flush();

            return $this->redirectToRoute('customemail_show', array('id' => $customEmail->getId()));
        }

        return $this->render('customemail/new.html.twig', array(
            'customEmail' => $customEmail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CustomEmail entity.
     *
     * @Route("/{id}", name="customemail_show")
     * @Method("GET")
     */
    public function showAction(CustomEmail $customEmail)
    {
        $deleteForm = $this->createDeleteForm($customEmail);

        return $this->render('customemail/show.html.twig', array(
            'customEmail' => $customEmail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CustomEmail entity.
     *
     * @Route("/{id}/edit", name="customemail_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CustomEmail $customEmail)
    {
        $deleteForm = $this->createDeleteForm($customEmail);
        $editForm = $this->createForm('AppBundle\Form\CustomEmailType', $customEmail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customEmail);
            $em->flush();

            return $this->redirectToRoute('customemail_edit', array('id' => $customEmail->getId()));
        }

        return $this->render('customemail/edit.html.twig', array(
            'customEmail' => $customEmail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CustomEmail entity.
     *
     * @Route("/{id}", name="customemail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CustomEmail $customEmail)
    {
        $form = $this->createDeleteForm($customEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($customEmail);
            $em->flush();
        }

        return $this->redirectToRoute('customemail_index');
    }

    /**
     * Creates a form to delete a CustomEmail entity.
     *
     * @param CustomEmail $customEmail The CustomEmail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CustomEmail $customEmail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customemail_delete', array('id' => $customEmail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
