<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ALSubject;
use AppBundle\Form\ALSubjectType;

/**
 * ALSubject controller.
 *
 * @Route("/alsubject")
 */
class ALSubjectController extends Controller
{
    /**
     * Lists all ALSubject entities.
     *
     * @Route("/", name="alsubject_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $aLSubjects = $em->getRepository('AppBundle:ALSubject')->findAll();

        return $this->render('alsubject/index.html.twig', array(
            'aLSubjects' => $aLSubjects,
        ));
    }

    /**
     * Creates a new ALSubject entity.
     *
     * @Route("/new", name="alsubject_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $aLSubject = new ALSubject();
        $form = $this->createForm('AppBundle\Form\ALSubjectType', $aLSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aLSubject);
            $em->flush();

            return $this->redirectToRoute('alsubject_show', array('id' => $aLSubject->getId()));
        }

        return $this->render('alsubject/new.html.twig', array(
            'aLSubject' => $aLSubject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ALSubject entity.
     *
     * @Route("/{id}", name="alsubject_show")
     * @Method("GET")
     */
    public function showAction(ALSubject $aLSubject)
    {
        $deleteForm = $this->createDeleteForm($aLSubject);

        return $this->render('alsubject/show.html.twig', array(
            'aLSubject' => $aLSubject,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ALSubject entity.
     *
     * @Route("/{id}/edit", name="alsubject_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ALSubject $aLSubject)
    {
        $deleteForm = $this->createDeleteForm($aLSubject);
        $editForm = $this->createForm('AppBundle\Form\ALSubjectType', $aLSubject);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aLSubject);
            $em->flush();

            return $this->redirectToRoute('alsubject_edit', array('id' => $aLSubject->getId()));
        }

        return $this->render('alsubject/edit.html.twig', array(
            'aLSubject' => $aLSubject,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ALSubject entity.
     *
     * @Route("/{id}", name="alsubject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ALSubject $aLSubject)
    {
        $form = $this->createDeleteForm($aLSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aLSubject);
            $em->flush();
        }

        return $this->redirectToRoute('alsubject_index');
    }

    /**
     * Creates a form to delete a ALSubject entity.
     *
     * @param ALSubject $aLSubject The ALSubject entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ALSubject $aLSubject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alsubject_delete', array('id' => $aLSubject->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
