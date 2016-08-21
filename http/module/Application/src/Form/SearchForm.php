<?php

namespace Application\Form;

use Zend\Form\Form;

class SearchForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('search');

        $this->add(
            [
                'name'       => 'query',
                'type'       => 'text',
                'attributes' =>
                [
                    'placeholder' => 'In Doody suchen',
                ],
            ]
        );
        $this->add(
            [
                'name'       => 'submit',
                'type'       => 'image',
                'attributes' =>
                [
                    'src' => '/img/doody/search-2.png',
                    'id'  => 'search',
                ],
            ]
        );
    }
}
