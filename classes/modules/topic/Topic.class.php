<?php

class PluginGeopost_ModuleTopic extends PluginTreeblogs_Inherit_ModuleTopic
{
    public function UpdateGeoData($oTopic)
    {
        return $this->oMapperTopic->UpdateGeoData($oTopic);
    }

    public function getTopicsByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY)
    {
        // TODO: cache by rect
        return $this->oMapperTopic->getTopicsByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY);
    }
}
