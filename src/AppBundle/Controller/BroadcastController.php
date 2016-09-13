<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Broadcast;
use AppBundle\Form\BroadcastType;

/**
 * Broadcast controller.
 *
 * @Route("/broadcast")
 */
class BroadcastController extends Controller
{
    /**
     * Lists all Broadcast entities.
     *
     * @Route("/", name="broadcast_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $broadcasts = $em->getRepository('AppBundle:Broadcast')->findAll();

        return $this->render('broadcast/index.html.twig', array(
            'broadcasts' => $broadcasts,
        ));
    }

    /**
     * Creates a new Broadcast entity.
     *
     * @Route("/new", name="broadcast_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $broadcast = new Broadcast();
        $form = $this->createForm('AppBundle\Form\BroadcastType', $broadcast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($broadcast);
            $em->flush();

            return $this->redirectToRoute('broadcast_show', array('id' => $broadcast->getId()));
        }

        return $this->render('broadcast/new.html.twig', array(
            'broadcast' => $broadcast,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Broadcast entity.
     *
     * @Route("/{id}", name="broadcast_show")
     * @Method("GET")
     */
    public function showAction(Broadcast $broadcast)
    {
        $deleteForm = $this->createDeleteForm($broadcast);

        return $this->render('broadcast/show.html.twig', array(
            'broadcast' => $broadcast,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Broadcast entity.
     *
     * @Route("/{id}/edit", name="broadcast_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Broadcast $broadcast)
    {
        $deleteForm = $this->createDeleteForm($broadcast);
        $editForm = $this->createForm('AppBundle\Form\BroadcastType', $broadcast);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($broadcast);
            $em->flush();

            return $this->redirectToRoute('broadcast_edit', array('id' => $broadcast->getId()));
        }

        return $this->render('broadcast/edit.html.twig', array(
            'broadcast' => $broadcast,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Broadcast entity.
     *
     * @Route("/{id}", name="broadcast_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Broadcast $broadcast)
    {
        $form = $this->createDeleteForm($broadcast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($broadcast);
            $em->flush();
        }

        return $this->redirectToRoute('broadcast_index');
    }

    /**
     * Creates a form to delete a Broadcast entity.
     *
     * @param Broadcast $broadcast The Broadcast entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Broadcast $broadcast)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('broadcast_delete', array('id' => $broadcast->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
