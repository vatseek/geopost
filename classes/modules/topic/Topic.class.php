<?php

class PluginGeopost_ModuleTopic extends PluginTreeblogs_Inherit_ModuleTopic
{
    public function UpdateGeoData($oTopic)
    {
        return $this->oMapperTopic->UpdateGeoData($oTopic);
    }
}
