<?php


namespace SIOFramework\Common\Controller;


interface WidgetInterface
{
    public function getPartial();

    public function renderWidget();
}