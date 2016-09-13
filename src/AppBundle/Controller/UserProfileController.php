<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserProfile;
use AppBundle\Form\UserProfileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * UserProfile controller.
 *
 * @Route("/userprofile")
 */
class UserProfileController extends Controller
{
    /**
     * Lists all UserProfile entities.
     *
     * @Route("/", name="userprofile_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('homepage');
        }
        $em = $this->getDoctrine()->getManager();

        $userProfiles = $em->getRepository('AppBundle:UserProfile')->findAll();

        return $this->render('userprofile/index.html.twig', array(
            'userProfiles' => $userProfiles,
        ));
    }

    /**
     * Creates a new UserProfile entity.
     *
     * @Route("/new", name="userprofile_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userProfile = new UserProfile();
        $form = $this->createForm('AppBundle\Form\UserProfileType', $userProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userProfile);
            $em->flush();

            return $this->redirectToRoute('userprofile_show', array('id' => $userProfile->getId()));
        }

        return $this->render('userprofile/new.html.twig', array(
            'userProfile' => $userProfile,
            'form'        => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UserProfile entity.
     *
     * @Route("/{id}", name="userprofile_show")
     * @Method("GET")
     */
    public function showAction(UserProfile $userProfile)
    {
        $deleteForm = $this->createDeleteForm($userProfile);

        return $this->render('userprofile/show.html.twig', array(
            'userProfile' => $userProfile,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UserProfile entity.
     *
     * @Route("/{id}/edit", name="userprofile_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserProfile $userProfile)
    {
        $deleteForm = $this->createDeleteForm($userProfile);
        $editForm = $this->createForm('AppBundle\Form\UserProfileType', $userProfile);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userProfile);
            $em->flush();

            return $this->redirectToRoute('userprofile_edit', array('id' => $userProfile->getId()));
        }

        return $this->render('userprofile/edit.html.twig', array(
            'userProfile' => $userProfile,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserProfile entity.
     *
     * @Route("/{id}", name="userprofile_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserProfile $userProfile)
    {
        $form = $this->createDeleteForm($userProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userProfile);
            $em->flush();
        }

        return $this->redirectToRoute('userprofile_index');
    }

    /**
     * Creates a form to delete a UserProfile entity.
     *
     * @param UserProfile $userProfile The UserProfile entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserProfile $userProfile)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userprofile_delete', array('id' => $userProfile->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
