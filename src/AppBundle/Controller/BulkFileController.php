<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\BulkFile;
use AppBundle\Form\BulkFileType;

// @todo remove all except new action
/**
 * BulkFile controller.
 *
 * @Route("/bulkfile")
 */
class BulkFileController extends Controller
{
    /**
     * Lists all BulkFile entities.
     *
     * @Route("/", name="bulkfile_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bulkFiles = $em->getRepository('AppBundle:BulkFile')->findAll();

        return $this->render('bulkfile/index.html.twig', array(
            'bulkFiles' => $bulkFiles,
        ));
    }

    /**
     * Creates a new BulkFile entity.
     *
     * @Route("/new", name="bulkfile_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bulkFile = new BulkFile();
        $form = $this->createForm('AppBundle\Form\BulkFileType', $bulkFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $bulkFile->getFilePath();
            $fileName = $this->get('app.csv_uploader')->upload($file);

            $bulkFile->setFilePath($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($bulkFile);
            $em->flush();

            $status = $this->get('app.csv_uploader')->process($bulkFile);
            if($status == true){
              $bulkFile->setComplete(true);
              $em = $this->getDoctrine()->getManager();
              $em->persist($bulkFile);
              $em->flush();
            }

            return $this->redirectToRoute('bulkfile_show', array('id' => $bulkFile->getId()));
        }

        return $this->render('bulkfile/new.html.twig', array(
            'bulkFile' => $bulkFile,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BulkFile entity.
     *
     * @Route("/{id}", name="bulkfile_show")
     * @Method("GET")
     */
    public function showAction(BulkFile $bulkFile)
    {
        $deleteForm = $this->createDeleteForm($bulkFile);

        return $this->render('bulkfile/show.html.twig', array(
            'bulkFile' => $bulkFile,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BulkFile entity.
     *
     * @Route("/{id}/edit", name="bulkfile_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BulkFile $bulkFile)
    {
        $deleteForm = $this->createDeleteForm($bulkFile);
        $editForm = $this->createForm('AppBundle\Form\BulkFileType', $bulkFile);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bulkFile);
            $em->flush();

            return $this->redirectToRoute('bulkfile_edit', array('id' => $bulkFile->getId()));
        }

        return $this->render('bulkfile/edit.html.twig', array(
            'bulkFile' => $bulkFile,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BulkFile entity.
     *
     * @Route("/{id}", name="bulkfile_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BulkFile $bulkFile)
    {
        $form = $this->createDeleteForm($bulkFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bulkFile);
            $em->flush();
        }

        return $this->redirectToRoute('bulkfile_index');
    }

    /**
     * Creates a form to delete a BulkFile entity.
     *
     * @param BulkFile $bulkFile The BulkFile entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BulkFile $bulkFile)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bulkfile_delete', array('id' => $bulkFile->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
