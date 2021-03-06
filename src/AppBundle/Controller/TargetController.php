<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Target;
use AppBundle\Form\TargetType;

/**
 * Target controller.
 *
 * @Route("/target")
 */
class TargetController extends Controller
{
    /**
     * Lists all Target entities.
     *
     * @Route("/", name="target_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $targets = $em->getRepository('AppBundle:Target')->findAll();

        return $this->render('target/index.html.twig', array(
            'targets' => $targets,
        ));
    }

    /**
     * Creates a new Target entity.
     *
     * @Route("/new", name="target_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $target = new Target();
        $form = $this->createForm('AppBundle\Form\TargetType', $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($target);
            $em->flush();

            return $this->redirectToRoute('target_show', array('id' => $target->getId()));
        }

        return $this->render('target/new.html.twig', array(
            'target' => $target,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Target entity.
     *
     * @Route("/{id}", name="target_show")
     * @Method("GET")
     */
    public function showAction(Target $target)
    {
        $deleteForm = $this->createDeleteForm($target);

        return $this->render('target/show.html.twig', array(
            'target' => $target,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Target entity.
     *
     * @Route("/{id}/edit", name="target_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Target $target)
    {
        $deleteForm = $this->createDeleteForm($target);
        $editForm = $this->createForm('AppBundle\Form\TargetType', $target);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($target);
            $em->flush();

            return $this->redirectToRoute('target_edit', array('id' => $target->getId()));
        }

        return $this->render('target/edit.html.twig', array(
            'target' => $target,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Target entity.
     *
     * @Route("/{id}", name="target_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Target $target)
    {
        $form = $this->createDeleteForm($target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($target);
            $em->flush();
        }

        return $this->redirectToRoute('target_index');
    }

    /**
     * Creates a form to delete a Target entity.
     *
     * @param Target $target The Target entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Target $target)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('target_delete', array('id' => $target->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
