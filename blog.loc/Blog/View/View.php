<?php

namespace Blog\View;

class View
{
    private $templatesPath;
    private $extraVars = [];

    public function __construct(string $tPath)
    {
        $this->templatesPath = $tPath;
    }

    public function setVar(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }

    public function renderHTML(string $templateName, array $vars = [], int $code = 200)
    {
        http_response_code($code);
        extract($this->extraVars);
        extract($vars);
        include $this->templatesPath . '/' . $templateName;
    }
}
?>