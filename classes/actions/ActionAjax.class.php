<?php

class PluginGeopost_ActionAjax extends PluginTreeblogs_Inherit_ActionAjax
{

    protected function RegisterEvent()
    {
        parent::RegisterEvent();

        $this->AddEvent('map', 'EventMap');
    }

    public function EventMap()
    {
        $iTopLeftX = getRequest('x1', false);
        $iTopLeftY = getRequest('y1', false);
        $iBotRightX = getRequest('x2', false);
        $iBotRightY = getRequest('y2', false);

        if ($iTopLeftX == false || $iTopLeftY == false || $iBotRightX == false || $iBotRightY == false) {
            $this->Viewer_SetResponseAjax(json_encode(array(
                    'result' => 'error',
                    'message' => 'some error')
            ));
        }

        $aTopic = $this->Topic_getTopicsByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY);
        foreach ($aTopic as $oTopic) {
            //TODO: create valid json
        }

        $this->Viewer_SetResponseAjax();
    }

}

