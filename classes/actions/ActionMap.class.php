<?php

class PluginMap_ActionPage extends ActionPlugin
{
    protected $sUserLogin = null;

    public function Init()
    {
    }

    /**
     * Регистрируем евенты
     *
     */
    protected function RegisterEvent()
    {
        $this->AddEvent('map', 'EventMap');
    }

    protected function EvenMap()
    {

    }
}