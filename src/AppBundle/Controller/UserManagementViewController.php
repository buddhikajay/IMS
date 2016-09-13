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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Inquiry view controller.
 *
 * @Route("/usermanagement")
 */
class UserManagementViewController extends Controller
{

    /**
     * Lists all ALSubject entities.
     *
     * @Route("/", name="usermanagement_view")
     * @Method("GET")
     */
    public function indexAction()
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('homepage');
        }

        $em = $this->getDoctrine()->getManager();

        $userProfiles = $em->getRepository('AppBundle:UserProfile')->getUserProfiles();

        return $this->render('custom_views/usermanagement.html.twig', array(
            'userProfiles' => $userProfiles,
        ));
    }

    /**
     * Update Level Of user
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/update",name="update_user_level")
     * @Method("POST")
     */
    public function updateUserLevelAction(Request $request)
    {
        $code = 200;
        $message = "User level Updated Successfully";
        $debug = "";
        try {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->find($request->get('id'));

            switch ($request->get('level')) {
                case 1:
                    $userLevel = "ROLE_COUNSELOR";
                    break;
                case 2:
                    $userLevel = "ROLE_DIRECTOR";
                    break;
                case 3:
                    $userLevel = "ROLE_MANAGER";
                    break;
                case 4:
                    $userLevel = "ROLE_SAR";
                    break;
                case 5:
                    $userLevel = "ROLE_ADMIN";
                    break;
                default:
                    $userLevel = " ";
            }

            $user->setRoles(array($userLevel));

            $em->persist($user);
            $em->flush();
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

    /**
     * Register New User
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/new_user",name="new_user")
     * @Method("POST")
     *
     */
    public function newUser(Request $request)
    {

        $code = 200;
        $message = "User Created Successfully";
        $debug = "";

        try {
            $userManager = $this->get('fos_user.user_manager');

            $user = $userManager->createUser();
            $user->setEmail($request->get('email'));
            $user->setUsername($request->get('username'));
            $user->setPlainPassword($request->get('password'));

            switch ($request->get('level')) {
                case 1:
                    $userLevel = "ROLE_COUNSELOR";
                    break;
                case 2:
                    $userLevel = "ROLE_DIRECTOR";
                    break;
                case 3:
                    $userLevel = "ROLE_MANAGER";
                    break;
                case 4:
                    $userLevel = "ROLE_SAR";
                    break;
                case 5:
                    $userLevel = "ROLE_ADMIN";
                    break;
                default:
                    $userLevel = "ROLE_COUNSELOR";
            }
            $user->setRoles(array($userLevel));
            $user->setEnabled(true);

            $userManager->updateUser($user);
            $this->getDoctrine()->getManager()->flush();
        } catch (Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

    /**
     * Deletes a Course entity.
     *
     * @Route("/", name="delete_user")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {
        $code = 200;
        $message = "User Deleted Successfully";
        $debug = "";
        try {
            $em = $this->getDoctrine()->getManager();
            $profile = $em->getRepository('AppBundle:UserProfile')->find($request->get('id'));

            if ($profile != null) {
                $user = $profile->getUserId();

                $em->remove($profile);
                $em->flush();

                $em->remove($user);
                $em->flush();
            }
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $debug = $request->get('id');
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }
}

