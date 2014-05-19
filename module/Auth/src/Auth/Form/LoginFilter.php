<?php

namespace Auth\Form;

use Zend\InputFilter;
use Zend\Validator;

class LoginFilter extends InputFilter\InputFilter
{
    public function __construct() {
        $username = new InputFilter\Input('username');
        $username->setRequired(true)
                 ->getFilterChain()
                    ->attachByName('stringtrim')
                    ->attachByName('stripTags');
        $username->getValidatorChain()->attach(new Validator\NotEmpty());
        
        $password = new InputFilter\Input('password');
        $password->setRequired(true)
                 ->getFilterChain()
                    ->attachByName('stringtrim')
                    ->attachByName('stripTags');
        $password->getValidatorChain()
                    ->attach(new Validator\NotEmpty());
        
        $this->add($username)->add($password);
        
    }
}

