<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class MenuAtivo extends AbstractHelper
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __invoke($url_menu = '')
    {
        return $this->request->getUri()->getPath() == $url_menu ? 'class="active"' : '';
    }
}