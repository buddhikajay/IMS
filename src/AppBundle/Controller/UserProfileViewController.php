<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/14/2016
 * Time: 8:08 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\UserProfile;
use AppBundle\Form\UserProfileViewType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Class UserProfileViewController
 * @package AppBundle\Controller
 * Manage Backend part of User profile information management
 * @Route("/profile")
 */
class UserProfileViewController extends Controller
{
    /**
     * Preview Users exiting profile
     * @Route("/",name="user_profile")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $profile = $em->getRepository('AppBundle:UserProfile')->findOneBy(array('userId' => $user));

        if ($profile == null) {
            $profile = new UserProfile();
            $profile->setUserId($user);
        }

        return $this->render('custom_views/profile.html.twig', array(
            'profile' => $profile,
        ));
    }

    /**
     * Update Profile Details
     * @param Request $request
     * @return JsonResponse
     * @Route("/update",name="update_profile")
     * @Method("POST")
     */
    public function updateProfileAction(Request $request)
    {
        $code = 200;
        $message = "Picture uploaded successfully";
        $debug = "No debug msg yet :)";

        $oldFileName = "";
        $isPicUpdated = false;
        $isSuccess = false;
        try {
            $em = $this->getDoctrine()->getManager();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $profile = $em->getRepository('AppBundle:UserProfile')->findOneBy(array('userId' => $user));

            if ($profile == null) {
                $profile = new UserProfile();
                $profile->setUserId($user);
                $oldFileName = "";
            }


            $file = $request->files->get('file');

            if ($file != null) {
                // Generate a unique name for the file before saving it
                $fileName = md5(uniqid()) . '.jpg';

                //move to web upload directory
                $file->move($this->getParameter('profile_pic_directory'), $fileName);

                $oldFileName = $profile->getProfilePic();
                $profile->setProfilePic($fileName);
                $isPicUpdated = true;
            }

            $profile->setFirstName($request->get('first_name'));
            $profile->setLastName($request->get('last_name'));
            $profile->setContact($request->get('contact'));

            $em->persist($profile);
            $em->flush();
            $isSuccess = true;

        } catch (\Exception $e) {
            $debug = "error in backend";
            $message = $e->getMessage();
            $code = $e->getCode();
        } finally {
            //delete old picture in server
            try {
                if ($isSuccess && $isPicUpdated && strlen($oldFileName) > 2) {
                    unlink($this->getParameter('profile_pic_directory') . '/' . $oldFileName);
                }
            } catch (Exception $e) {

            }

            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }


    }

    /**
     * change password
     * @param Request $request
     * @return JsonResponse
     * @Method("POST")
     * @Route("change_password",name="edit_password")
     */
    public function changePassword(Request $request)
    {
        $code = 200;
        $message = "Password changed Successfully";
        $debug = "";

        try {
            $userManager = $this->get('fos_user.user_manager');

            $user = $this->get('security.token_storage')->getToken()->getUser();

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);

            $password = $request->get('current');
            $bool = ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) ? "true" : "false";

            if ($bool) {
                $user->setPlainPassword($request->get('newpass'));


                $userManager->updateUser($user);
                $this->getDoctrine()->getManager()->flush();
            } else {
                $message = "incorrect password";
                return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
            }
        } catch (Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();

        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }

    }

    /**
     * upload image
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/upload",name="wtf")
     * @Method({"POST","GET"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $profile = $em->getRepository('AppBundle:UserProfile')->findOneBy(array('userId' => $user));

        if ($profile == null) {
            $profile = new UserProfile();
            $profile->setUserId($user);
        }
        $form = $this->createForm(UserProfileViewType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $file = $form['profile_pic']->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.jpg';

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('profile_pic_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $profile->setProfilePic($fileName);
            $profile->setContact($form['contact']->getData());
            $profile->setFirstName($form['first_name']->getData());
            $profile->setLastName($form['last_name']->getData());


            $em->persist($profile);
            $em->flush();

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return $this->render('custom_views/wtf.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}