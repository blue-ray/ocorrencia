<?php

namespace Auth\Form;

use Zend\Form\Form;
use Zend\Form\Element\Captcha;
use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Captcha\Image as CaptchaImage;
use Zend\Form\Element;

class EsqueciSenhaForm extends Form {

    public function __construct($dircaptcha = null, $urlcaptcha = null) {
        parent::__construct('Test Form Captcha');
        $this->setAttribute('method', 'post');


        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
            ),
            'options' => array(
                'label' => 'Informe o e-mail cadastrado:',
            ),
            'attributes' => array(
                'required' => 'required'
            ),
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'messages' => array(\Zend\Validator\EmailAddress::INVALID_FORMAT => 'O formato inválido'
                        )
                    )
                )
            )
        ));

        $dirdata = './data';

        //pass captcha image options
        $captchaImage = new CaptchaImage(array(
            'font' => $dirdata . '/fonts/arial.ttf',
            'width' => 150,
            'height' => 60,
            'dotNoiseLevel' => 40,
            'lineNoiseLevel' => 3)
        );

        $captchaImage->setImgDir($dircaptcha);

        //var_dump($urlcaptcha);
        $captchaImage->setImgUrl($urlcaptcha);

        //add captcha element...
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Digite os caracteres abaixo',
                'captcha' => $captchaImage,
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Enviar nova senha'
            ),
        ));
    }

}