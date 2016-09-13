<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/7/2016
 * Time: 3:13 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Target;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inquiry view controller.
 *
 * @Route("/targets")
 */
class TargetViewController extends Controller
{

    /**
     * Lists all ALSubject entities.
     *
     * @Route("/", name="targets_view")
     * @Method("GET")
     */
    public function indexAction()
    {
        // @ToDo Grab data from DB and pass to frontend
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        $targets = $em->getRepository('AppBundle:Target')->findAll(); //todo: show active targets only
        return $this->render('custom_views/targets.html.twig', array(
            'users' => $users,
            'targets' => $targets
        ));
    }


    /**
     * Creates a new Target entity.
     *
     * @Route("/", name="targets_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $code = 200;
        $message = "New Target Created Successfully";
        $debug = "";
        try {
            $em = $this->getDoctrine()->getManager();
            $target = new Target();
            $target->setTimestamp(new \DateTime("now"));
            $target->setAmount($request->get('value'));

            $assigner = $this->get('security.token_storage')->getToken()->getUser();
            $target->setAssigner($assigner);

            $counselor = $this->get('fos_user.user_manager')->findUserByEmail($request->get('name'));
            $target->setCouncellor($counselor);

            $target->setEndDate(new \DateTime($request->get('start_date')));
            $target->setStartDate(new \DateTime($request->get('end_date')));

            $em->persist($target);
            $em->flush();
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }


}

