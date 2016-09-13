<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('marketing_dashboard');
        }
        if ($this->isGranted('ROLE_SAR')) {
            return $this->redirectToRoute('admissions_view');
        }
        if ($this->isGranted('ROLE_COUNSELOR')) {
            return $this->redirectToRoute('marketing_dashboard');
        }
        if ($this->isGranted('ROLE_DIRECTOR')) {
            return $this->redirectToRoute('reports_view');
        }
        if ($this->isGranted('ROLE_MANAGER')) {
            return $this->redirectToRoute('reports_view');
        }




        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }
}
