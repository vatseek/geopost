<?php

class PluginGeopost_ModuleTopic extends PluginTreeblogs_Inherit_ModuleTopic
{
    public function UpdateGeoData($oTopic)
    {
        return $this->oMapperTopic->UpdateGeoData($oTopic);
    }

    public function getTopicsIdByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY)
    {
        $iMinX = floor(min($iTopLeftX, $iBotRightX));
        $iMaxX = ceil(max($iTopLeftX, $iBotRightX));
        $iMinY = floor(min($iTopLeftY, $iBotRightY));
        $iMaxY = ceil(max($iTopLeftY, $iBotRightY));

        if ($iMinX == $iMaxX) {
            $iMaxX = $iMinX + 1;
        }

        if ($iMinY == $iMaxY) {
            $iMaxY = $iMinY + 1;
        }

        $aCoordinatesKeys = array();
        for ($x = $iMinX; $x < $iMaxX; $x++) {
            for ($y = $iMinY; $y < $iMaxY; $y++) {
                $aCoordinatesKeys[] = "{$x}_{$y}";
            }
        }

        $aRectNotNeedQuery = array();
        $aCacheKeys = func_build_cache_keys($aCoordinatesKeys, 'topic_coordinate_rect_');
        $aTopics = array();
        foreach ($aCacheKeys as $sValue => $sKey) {
            if (false !== ($data = $this->Cache_Get($sKey))) {
                $aTopics = array_merge($aTopics, $data);
                $aRectNotNeedQuery[$sValue] = $sValue;
            }
        }

        $aRectNeedToQuery = array();
        for ($x = $iMinX; $x < $iMaxX; $x++) {
            for ($y = $iMinY; $y < $iMaxY; $y++) {
                if (!isset($aRectNotNeedQuery["{$x}_{$y}"])) {
                    $aRectNeedToQuery[] = array('x' => $x, 'y' => $y);
                }
            }
        }

        if ($aRectNeedToQuery) {
            $aTopicZones = $this->oMapperTopic->getTopicsIdZones($aRectNeedToQuery);
            foreach ($aTopicZones as $sKey => $aTopicsZone) {
                $aTopics = array_merge($aTopics, $aTopicsZone);
                $this->Cache_Set($aTopicsZone, "topic_coordinate_rect_{$sKey}", array(), 60 * 60 * 24 * 1);
            }
        }

        return $aTopics;
    }
}
