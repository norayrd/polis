<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use DateTime;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller used to manage the application security.
 * See http://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login_form")
     */
    public function loginAction(Request $request)
    {
        
        // Getting message from session (if successfully registered)
        $session = $this->getRequest()->getSession();
        $message_text = $session->get('regsuccess');
        $registered_email = $session->get('regemail');
        $session->remove('regsuccess');
        $session->remove('regemail');
        
        $hideRegistrationButton = 0;
        if ($this->container->hasParameter('hide_registration_button')) {
            $hideRegistrationButton = ($this->container->getParameter('hide_registration_button')==1)?1:0;
        }
        
        $helper = $this->get('security.authentication_utils');
        
        return $this->render('security/login.html.twig', array(
            // last username entered by the user (if any)
            'last_username' => $helper->getLastUsername(),
            // last authentication error (if any)
            'error' => $helper->getLastAuthenticationError(), 
            'message_text' => $message_text,
            'registered_email' => $registered_email,
            'hide_registration_button' => $hideRegistrationButton,
        ));

    }

    /**
     * @Route("/sign-up", name="security_sign_up_form")
     */
    public function signUpAction($error = array())
    {
        $request = $this->getRequest();
        $err = array();
        $error_text = "";
        
        $hideRegistrationButton = 0;
        if ($this->container->hasParameter('hide_registration_button')) {
            $hideRegistrationButton = ($this->container->getParameter('hide_registration_button')==1)?1:0;
        }
        
        $phash=null;
        $pemail = null;

        if ($hideRegistrationButton == 1) {
            $phash = $request ->get("i");
            $pemail = rawurldecode( $request ->get("email"));
        
            $iKeyService = $this->get("i_key_service");
            
            $iKey = $iKeyService ->findIKey( $pemail, $phash );
            
            $securityService = $this->get("security_service");
            
            $foundUser = $securityService->findUserByEmail( $pemail );

            
            if ( !$iKey || is_object($foundUser) ) {
                
                return $this->render('security/sign_up_wrong_url.html.twig', array(
                    'message' => 'Устаревшая или не существующая ссылка!',
                ));
            }
            
        }
        
        if (!empty($error)) {
            $error_text = "Have some errors!";
        }
        
        return $this->render('security/sign_up.html.twig', array(
            'last_request' => $request->request,
            'error_text' => $error_text,
            'errors' => $error,
            'hash' => $phash,
            'email' => $pemail,
        ));

    }

    /**
     * @Route("/sign-up-check", name="security_sign_up_check")
     */
    public function signUpCheckAction()
    {
        $request = $this->getRequest();
        $validator = $this->get('validator');
        
        $password = $request->request->get("_password");
        $retype_password = $request->request->get("_retype_password");
        $email = $request->request->get("_email");
        $username = $email;
        
        $errors = array();
        $securityService = $this->get("security_service");
        $user = $securityService->findUsername($username);
        if ( isset($user) ) {
            $errors["username"] = "Username already used!";
        }
        
        if ( $retype_password !== $password ) {
            $errors["retype_password"] = "The passwords does not match!";
        }

        
        $user = new User();
        $user -> setFirstname($request->request->get("_firstname"));
        $user -> setLastname($request->request->get("_lastname"));
        //$user -> setUsername($request->request->get("_username"));
        $user -> setPassword($password);
        $user -> setEmail($email);
        $user -> setUsername($email);
        $user -> setRoles(array());
 
        $error = $validator->validate($user);
        foreach ($error as $val) {
            $errors[$val->getPropertyPath()] = $val->getMessage();
        }

        if ( (count($errors)>0) ) {
            return $this->forward("AppBundle:Security:signUp", array('error' => $errors) );
            
        } else {
            // encoding password
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($request->request->get("_password"), $user->getSalt());
            $user->setPassword($password);
            
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();
            
            //sending message throug session
            $message_text = "You have successfully registered ".$email.". Now sign in and start analyzing influencers!";
            $session = $this->getRequest()->getSession();
            $session->set('regsuccess', $message_text);
            $session->set('regemail', $email);

            return $this->redirect($this->generateUrl('security_login_form'));
        }
    }

    /**
     * This is the route the login form submits to.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the login automatically. See form_login in app/config/security.yml
     *
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        throw new Exception('This should never be reached!');
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new Exception('This should never be reached!');
    }
    
    /*
     * Checking if email registered
     * 
     * @Route("/sign-up/check-email", name="check_email")
     */
    public function checkEmailAction(Request $request) {

        $username = $request ->get("email");
        
        if (isset($username)) {
            $securityService = $this->get("security_service");
            $user = $securityService->findUsername($username);
        } else {
            $user = null;
        }

        $result = array( "email" => $username, "result" => isset($user) );

        //return new Response(json_encode($result), 200, array('Content-Type', 'application/json'));
        
        $response = new Response();
        $response->setContent( json_encode($result) );
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    /*
     * Forgot password
     * 
     * @Route("/forgot-password", name="forgot_password")
     */
    public function forgotPasswordAction(Request $request) {

        $username = $request ->get("_email");
        $email = '';
        
        if ( ($request->getMethod('post') == 'POST') && isset($username) ) {
            $securityService = $this->get("security_service");
            $user = $securityService->findUsername($username);
        } else {
            $user = null;
        }
        
        if (is_object($user)) {
            $email = trim($user->getEmail());
        }
        
        $success_message_text = null;
        $error_message_text = null;
        
        if ( filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            
            $securityService = $this->get("security_service");
            $hash = $securityService ->getForgotPasswordHash($user, $this->container->getParameter('secret'));
            
            $forgot_link = $this->generateUrl('change_password',array(),true) . 
                    '?email=' . rawurlencode($email) .
                    '&h=' . $hash ;
            
            $email_from_name = $this->container->getParameter('support_email_from_name');
            $email_from = $this->container->getParameter('support_email_from');
            $email_replay_to = $this->container->getParameter('support_email_replay_to');
            $email_footer_message = $this->container->getParameter('support_email_footer_message');
            $base_url = $this->container->getParameter('base_url');
            $base_url_name = $this->container->getParameter('base_url_name');
        
            $mail_params = array(
                'fullname' => $user->getFirstName().' '.$user->getLastName(),
                'forgot_link' => $forgot_link,
                'email_footer_message' => $email_footer_message,
                'base_url' => $base_url,
                'base_url_name' => $base_url_name,
            );
                
            $message = $this->get('mail_manager');
            $message->sendEmail('emails/forgot_password_email.html.twig', $mail_params, $email, $email_from, $email_from_name, $email_replay_to);
           
            $success_message_text = 'На указанную почту было отправлено письмо для изменения пароля.';
        } else if (isset($username)) {
            
            $error_message_text = 'User not found!';
        }
        
        return $this->render('security/forgot_password.html.twig', array(
            'success_message_text' => $success_message_text,
            'error_message_text' => $error_message_text,
            'username' => $username,
        ));
    }
    
    /*
     * Change password
     * 
     * @Route("/change-password", name="change_password")
     */
    public function changePasswordAction(Request $request) {
        
        $em = $this->getDoctrine()->getEntityManager();
        $email = rawurldecode($request ->get("email"));
        $hash = $request ->get("h");
        
        $newPassword = $request ->get("_new_password");
        $retypePassword = $request ->get("_retype_password");

        $resetGranted = false;
        $resetSuccess = false;
        
        $success_message_text = '';
        $error_message_text = '';
        $username = '';
        
        $securityService = $this->get("security_service");

        if ( isset($email) && isset($hash) ) {
            $user = $securityService->findUserByEmail($email);
        } else {
            $user = null;
        }
        
        $now = new DateTime();
        
        if (is_object($user)) {
            $forgotPasswordHash = $user->getForgotPasswordHash();
            $forgotPasswordExpireDatetime = $user->getForgotPasswordExpireDatetime();
            $username = $user->getFirstname() . " " . $user->getLastname();

            if ( ($forgotPasswordHash == $hash) && isset($forgotPasswordExpireDatetime) && ($forgotPasswordExpireDatetime >= $now) ) {
                $resetGranted = true;
            }
        }
        
        if ($resetGranted && isset($newPassword) && (strlen($newPassword)>0) && ($newPassword == $retypePassword)) {
            
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($newPassword, $user->getSalt());
            $user->setPassword($password);
            $user->setForgotPasswordHash(null);
            $user->setForgotPasswordExpireDatetime(null);

            $em ->persist($user);
            $em ->flush();
            
            $resetSuccess = true;
        }
        
        if ($resetSuccess) {
            $success_message_text = 'The password is successfully changed!';
        } else if (!$resetGranted) {
            $error_message_text = 'This link is wrong or expired!';
        }
        
        return $this->render('security/forgot_password_reset.html.twig', array(
            'success_message_text' => $success_message_text,
            'error_message_text' => $error_message_text,
            'username' => $username,
        ));
    }
}
