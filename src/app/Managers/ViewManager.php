<?php

namespace Codebase\Managers;

class ViewManager
{
    private $viewFolder;

    private $viewLayoutFile;

    private $params;
    
    public function __construct(String $viewFolder, String $viewLayoutFile) {
        $this->viewFolder = $viewFolder . '/';
        $this->viewLayoutFile = $viewLayoutFile;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams(Array $params)
    {
        $this->params = $params;
    }

    public function render(String $templateFile, Array $parameters = []) {
        $page = $this->processTemplateFile($templateFile, $parameters);
        $html = str_replace("{{ body }}", $page, file_get_contents($this->viewFolder . $this->viewLayoutFile));

        return $html;
    }

    private function processTemplateFile(String $templateFile, Array $parameters = []) {
        ob_start();
        $this->setParams($parameters);
        include($this->viewFolder . $templateFile);
        $page = ob_get_contents();
        ob_end_clean();
        
        return $page;
    }

}