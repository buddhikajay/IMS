<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Followup;
use AppBundle\Form\FollowupType;

/**
 * Followup controller.
 *
 * @Route("/followup")
 */
class FollowupController extends Controller
{
    /**
     * Lists all Followup entities.
     *
     * @Route("/", name="followup_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $followups = $em->getRepository('AppBundle:Followup')->findAll();

        return $this->render('followup/index.html.twig', array(
            'followups' => $followups,
        ));
    }

    /**
     * Creates a new Followup entity.
     *
     * @Route("/new", name="followup_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $followup = new Followup();
        $form = $this->createForm('AppBundle\Form\FollowupType', $followup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($followup);
            $em->flush();

            return $this->redirectToRoute('followup_show', array('id' => $followup->getId()));
        }

        return $this->render('followup/new.html.twig', array(
            'followup' => $followup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Followup entity.
     *
     * @Route("/{id}", name="followup_show")
     * @Method("GET")
     */
    public function showAction(Followup $followup)
    {
        $deleteForm = $this->createDeleteForm($followup);

        return $this->render('followup/show.html.twig', array(
            'followup' => $followup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Followup entity.
     *
     * @Route("/{id}/edit", name="followup_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Followup $followup)
    {
        $deleteForm = $this->createDeleteForm($followup);
        $editForm = $this->createForm('AppBundle\Form\FollowupType', $followup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($followup);
            $em->flush();

            return $this->redirectToRoute('followup_edit', array('id' => $followup->getId()));
        }

        return $this->render('followup/edit.html.twig', array(
            'followup' => $followup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Followup entity.
     *
     * @Route("/{id}", name="followup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Followup $followup)
    {
        $form = $this->createDeleteForm($followup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($followup);
            $em->flush();
        }

        return $this->redirectToRoute('followup_index');
    }

    /**
     * Creates a form to delete a Followup entity.
     *
     * @param Followup $followup The Followup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Followup $followup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('followup_delete', array('id' => $followup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
