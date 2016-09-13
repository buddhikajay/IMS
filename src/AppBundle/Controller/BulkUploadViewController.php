<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/7/2016
 * Time: 3:13 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Inquiry view controller.
 *
 * @Route("/bulkupload")
 */
class BulkUploadViewController extends Controller{

    /**
     * Lists all ALSubject entities.
     *
     * @Route("/", name="bulkupload_view")
     * @Method("GET")
     */
    public function indexAction()
    {
        // @ToDo Grab data from DB and pass to frontend
        return $this->render('custom_views/bulkupload.html.twig',array());
    }
}

