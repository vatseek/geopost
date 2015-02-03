<?php

class PluginGeopost_ModuleTopic extends PluginTreeblogs_Inherit_ModuleTopic
{
    public function UpdateGeoData($oTopic)
    {
        return $this->oMapperTopic->UpdateGeoData($oTopic);
    }

    public function getTopicsIdByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY)
    {
        // TODO: cache by rect
        return $this->oMapperTopic->getTopicsIdByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY);
    }
}
