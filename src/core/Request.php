<?php

namespace NotSymfony\core;


class Request
{
    public string $fullURL;
    public string $fullPath;
    public array $URLVariables = [];

    public function __construct(string $fullURL)
    {
        $this->fullURL = $fullURL;
        $exploded = explode("?", $fullURL);
        $this->fullPath = $exploded[0];
        if (isset($exploded[1])) {
            $this->URLVariables = $this->getURLVariables($exploded[1]);
        }
    }


    /**
     * @return string
     */
    public function getPath(): string
    {
        $path = explode("/", $this->fullPath);
        if ($position = array_search("public", $path)) {
            $path = array_splice($path, $position + 1);
        }
        return implode("/", $path);
    }

    /**
     * @param string $unparsed_url
     * @return array
     */
    public function getURLVariables(string $unparsed_url): array
    {
        $url_variables = [];
        $exploded = explode("&", $unparsed_url);
        foreach ($exploded as $get_variable) {
            $temp = explode("=", $get_variable);
            $url_variables[$temp[0]] = $temp[1];
        }
        return $url_variables;
    }

    public function getURLVariable(string $key): string
    {
        return $this->URLVariables[$key] ?? '';
    }

    /**
     * @param string $key
     * @return string
     */
    public function getPOSTValue(string $key): string
    {
        return $_POST[$key] ?? '';
    }
}