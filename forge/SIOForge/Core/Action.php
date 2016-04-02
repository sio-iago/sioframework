<?php


namespace SIOForge\Core;


interface Action
{
    /**
     * Performs the action.
     * No return required.
     *
     * @param $args array
     * @param $environment Environment
     */
    public function performAction(Environment $environment, $args);
}