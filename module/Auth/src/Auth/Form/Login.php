<?php

namespace Auth\Form;

use Zend\Form\Form;

class Login extends Form {

    public function __construct() {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/ocorrencia/public/auth/login');
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'form-horizontal');
        $this->setInputFilter(new LoginFilter());
               
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Username',
            ),
            
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
            
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Entrar',
                'id' => 'submitbutton',
            ),
        ));
    }

}
