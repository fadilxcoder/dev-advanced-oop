<?php

namespace Codebase\Managers;

class ViewManager
{
    private $viewFolder;

    private $viewLayoutFile;
    
    public function __construct(String $viewFolder, String $viewLayoutFile) {
        $this->viewFolder = $viewFolder . '/';
        $this->viewLayoutFile = $viewLayoutFile;
    }

    public function render(String $templateFile, Array $parameters = []) {
        $page = $this->processTemplateFile($templateFile, $parameters);
        $html = str_replace("{{ body }}", $page, file_get_contents($this->viewFolder . $this->viewLayoutFile));

        return $html;
    }

    private function processTemplateFile(String $templateFile, Array $parameters = []) {
        ob_start();
        include($this->viewFolder . $templateFile);
        $page = ob_get_contents();
        $page = str_replace("{{ ", "{{", $page);
        $page = str_replace(" }}", "}}", $page);

        // dump($parameters);die;
        
        foreach ($parameters as $key => $value) {
            $page = str_replace("{{".$key."}}", $value, $page);
        }
        
        ob_end_clean();
        
        return $page;
    }

}