<?php

namespace Auth\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Auth\Form\Login;
use Auth\Form\EsqueciSenhaForm;

use Zend\Mail;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;

/**
 * Controlador que gerencia a autenticação
 */
class AuthController extends AbstractActionController {

    /**
     * Mostra o formulário de login
     * @return void
     */
    public function indexAction() {
        $form = new Login();
        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * Faz o login do usuário
     * @return void
     */
    public function loginAction() {
        $form = new Login();
        $request = $this->getRequest();
        if (!$request->isPost()) {
            $this->flashMessenger()->addErrorMessage("Acesso inválido");
            return $this->redirect()->toUrl('/ocorrencia/public/auth');
        }
        $data = $request->getPost();

        $form->setData($data);
        if (!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => true,
                'form' => $form,
            ));
            $model->setTemplate('auth/auth/index');
            return $model;
        }

        $service = $this->getServiceLocator()->get('Auth\Service\Auth');
        $auth = $service->authenticate(
                array(
                    'username' => $data['username'],
                    'password' => $data['password']
                )
        );
        if (!$auth) {
            return $this->redirect()->toUrl('/ocorrencia/public/auth');
        }
        
        return $this->redirect()->toUrl('/ocorrencia/public/');
    }

    /**
     * Faz o logout do usuário
     * @return void
     */
    public function logoutAction() {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            $service = $this->getServiceLocator()->get('Auth\Service\Auth');
            $service->logout();
            return $this->redirect()->toUrl('/auth');
        }
        
        return $this->redirect()->toUrl('/auth');
    }

    public function esqueciAction() {

        $dircaptcha = dirname(__DIR__) . "/../../../../public/images/captcha/";
        $urlcaptcha = "/images/captcha";
        $form = new EsqueciSenhaForm($dircaptcha, $urlcaptcha);

        //$this->deletaImagensCaptcha($dircaptcha);
        return array('form' => $form);
    }

    public function enviarAction() {
        $form = new EsqueciSenhaForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $email = $form->get('email')->getValue();

                $bd = $this->serviceLocator->get('Application\Model\UserTable');
                $usuario = $bd->validateEmail($email);

                //verifica se o e-mail está cadastrado
                if ($usuario) {
                    if (!$this->enviarEmail($usuario)) {
                        $this->flashMessenger()->addErrorMessage("Erro ao enviar o e-mail");
                        return $this->redirect()->toUrl('/auth/enviar');
                    }
                }
                return array('usuario'=>$usuario, 'email' => $email);
            } else {
                return $this->redirect()->toRoute('esqueci', array(
                            'controller' => 'auth',
                            'action' => 'esqueci',));
            }
        } else {
            $this->flashMessenger()->addErrorMessage("Acesso inválido");
            return $this->redirect()->toUrl('/auth/enviar');
        }        
    }

    private function deletaImagensCaptcha($path) {
        $files = glob($path);
        foreach ($files as $file) {
            if (is_file($file)) {
                var_dump($file);
                //unlink($file);
            }
        }
    }

    protected function enviarEmail($usuario) {
        //opções do SMTP
        $options = new Mail\Transport\SmtpOptions(array(
            'name' => 'localhost',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'username' => 'mail0teste@gmail.com',
                'password' => 'teste@123',
                'ssl' => 'tls',
            ),
        ));

        //$this->renderer = $this->getServiceLocator()->get('ViewRenderer');
        //$content = $this->renderer->render('application/auth/body-email', null);

        /*
        $html = new MimePart($content);
        $html->type = "text/html";
        $body = new MimeMessage();
        $body->setParts(array($html,));
         * 
         */
        $body = 'Nome: '.$usuario->email.'<br>E-mail:.'.$usuario->email.'<br>.Nova senha: 1234';

        // instance mail 
        $mail = new Mail\Message();
        $mail->setBody($body); // will generate our code html from template.phtml
        $mail->setFrom('mail0teste@gmail.com', 'Orion');
        $mail->setTo($usuario->email, $usuario->nome);
        $mail->setSubject('Nova senha');

        $transport = new Mail\Transport\Smtp($options);
        $transport->send($mail);

        return true;
    }
    
}



