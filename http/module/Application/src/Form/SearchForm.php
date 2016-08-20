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
                'name' => 'query',
                'type' => 'text',
                'attributes' => [
                    'placeholder' => 'In Doody suchen',
                ],
            ]
        );

        $this->add(
            [
                'name' => 'submit',
                'type' => 'submit',
                'attributes' => [
                    'id' => 'search',
                    'value' => 'Suchen',
                ],
            ]
        );
    }
}
