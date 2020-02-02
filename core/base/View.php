<?php

namespace base;

class View
{
    public $basePath = __DIR__.'/../views/templates/';
    protected $title;
    protected $css = [];
    protected $js = [];

    protected $_layout;

    public function render($tplName, $data)
    {
        include $this->_layout;
    }

    /**
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->_layout = __DIR__.'/../views/layouts/'.$layout.'.php';
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param array $css
     */
    public function addCss($cssArr)
    {
        foreach ($cssArr as $css) {
            $this->css[] = $css;
        }
    }

    /**
     * @return array
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * @param array $js
     */
    public function addJs($jsArr)
    {
        foreach ($jsArr as $js) {
            $this->js[] = $js;
        }
    }
}
