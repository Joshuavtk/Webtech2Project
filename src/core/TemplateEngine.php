<?php

namespace NotSymfony\core;

class TemplateEngine
{

    /**
     * @param $base_template
     * @return string
     */
    public function render($base_template): string
    {
        return $this->renderTemplate("", $base_template);
    }

    /**
     * Recursive function that builds a template file and calls itself when
     * a @component() tag is found in the template and builds that template file.
     *
     * @param $baseTemplate
     * @param string $templateName
     * @return string
     */
    public function renderTemplate($baseTemplate, string $templateName): string
    {
        ob_start();
        require_once sprintf("%s/../templates/%s.php", __DIR__, $templateName);
        $template = ob_get_clean();

        if ($baseTemplate !== "") {
            $template = str_replace("@component('" . $templateName . "')", $template, $baseTemplate);
        }

        if (str_contains($template, "@component")) {
            preg_match_all('/@component\(\'[^\']*\'\)/', $template, $output_array);

            $newTemplateName = explode("'", $output_array[0][0])[1];
            return $this->renderTemplate($template, $newTemplateName);
        }
        return $template;
    }
}