<?php


namespace SIOForge\Core;


abstract class TwigRenderAction
{
    /**
     * Gets the template engine
     *
     * @param $environment string
     * @return \Twig_Environment
     */
    protected function getTemplateEngine($templatesDir)
    {
        $loader = new \Twig_Loader_Filesystem($templatesDir);

        $twig = new \Twig_Environment($loader, array('cache'));
        $twig->addGlobal('leftEscapePercent','{%');
        $twig->addGlobal('rightEscapePercent','%}');
        $twig->addGlobal('leftEscapeBracket','{{');
        $twig->addGlobal('rightEscapeBracket','}}');

        return $twig;
    }
}