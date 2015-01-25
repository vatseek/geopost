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
        $this->Viewer_Assign('noSidebar', true);
        $this->SetTemplateAction('map');
    }
}