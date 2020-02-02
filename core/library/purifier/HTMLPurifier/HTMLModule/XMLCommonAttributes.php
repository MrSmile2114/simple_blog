<?php

class HTMLPurifier_HTMLModule_XMLCommonAttributes extends HTMLPurifier_HTMLModule
{
    /**
     * @var string
     */
    public $name = 'XMLCommonAttributes';

    /**
     * @var array
     */
    public $attr_collections = [
        'Lang' => [
            'xml:lang' => 'LanguageCode',
        ],
    ];
}

// vim: et sw=4 sts=4
