<?php

class PluginGeopost_ActionMap extends ActionPlugin
{
    protected $oUserCurrent = null;
    protected $sMenuHeadItemSelect = 'map';
    protected $sMenuItemSelect = 'map';
    protected $sMenuSubItemSelect = 'map';

    public function Init()
    {

    }

    protected function RegisterEvent()
    {
        $this->AddEvent('index', 'EventMap');
        $this->SetDefaultEvent('index');
    }

    protected function EventMap()
    {
        die('123');
        $this->SetTemplateAction('map');
    }
}