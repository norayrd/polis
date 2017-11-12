<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PolisController extends Controller
{

    /**
     * @Route("/report", name="report")
     */
    public function reportAction(Request $request){

        $is_guest = !is_object($this->getUser());

        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Отчет', 'url' => null),
        );
        
        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/report.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
        ));

    }

    /**
     * @Route("/invitation-sign-up", name="invitation_sign_up")
     */
    public function invitationSignUpAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $companyService = $this->get("company_service");
        
        if ( $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $companyList = $companyService ->getCompanyList($this->getUser());
        } else {
            
            $companyList = null;
        }

        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Приглашение на регистрацию', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/invitation_sign_up.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'companyList' => $companyList,
        ));

    }
    
    /**
     * @Route("/send-invitation-sign-up", name="send_invitation_sign_up")
     */
    public function sendInvitationSignUpAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $pemail = $request ->get("u_email");
        $pcompanyId = $request ->get("u_company_id");

        if ( $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $user = $this->getUser();
            
            $iKeyService = $this->get("i_key_service");
            
            $piKey = $iKeyService ->createIKey($user, $pemail, $pcompanyId, $this->container->getParameter('secret') );
            
            $hash = $piKey ->getIKey();

            $signup_link = $this->generateUrl('sign_up',array('i' => $hash, 'email' => rawurlencode($pemail)),true);

            $email_from_name = $this->container->getParameter('support_email_from_name');
            $email_from = $this->container->getParameter('support_email_from');
            $email_replay_to = $this->container->getParameter('support_email_replay_to');
            $email_footer_message = $this->container->getParameter('support_email_footer_message');
            $base_url = $this->container->getParameter('base_url');
            $base_url_name = $this->container->getParameter('base_url_name');

            $mail_params = array(
                'signup_link' => $signup_link,
                'email_footer_message' => $email_footer_message,
                'base_url' => $base_url,
                'base_url_name' => $base_url_name,
            );

            $message = $this->get('mail_manager');

            $message->sendEmail('emails/sign_up_email.html.twig', $mail_params, $pemail, $email_from, $email_from_name, $email_replay_to);
            
            //$success_message_text = 'На указанную почту было отправлено письмо для изменения пароля.';
            
        } else {
            
        }
        
        return $this->redirect($this->generateUrl('invitation_sign_up'));
    }
    
}