<?php

class PluginGeopost_ModuleTopic_MapperTopic extends PluginTreeblogs_Inherit_ModuleTopic_MapperTopic
{
    public function UpdateGeoData($oTopic)
    {
        $sql = "UPDATE " . Config::Get('db.table.topic') . " AS _t
                SET _t.lat = ?f,
                    _t.long = ?f
                WHERE
                    _t.topic_id = ?d ";

        $this->oDb->query($sql, $oTopic->getLat(), $oTopic->getLong(), $oTopic->getId());
        return true;
    }

    public function getTopicsByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY)
    {
        $x1 = min($iTopLeftX, $iBotRightX);
        $x2 = max($iTopLeftX, $iBotRightX);
        $y1 = min($iTopLeftY, $iBotRightY);
        $y2 = max($iTopLeftY, $iBotRightY);

        $sql = "SELECT
                  *
                FROM " . Config::Get('db.table.topic') . " AS _t
                WHERE
                    _t.lat >= ?f
                    AND _t.lat <= ?f
                    AND _t.long >= ?f
                    AND _t.long <= ?f
                    AND _t.topic_publish = 1 ";

        $aTopics = array();
        if ($aRows = $this->oDb->select($sql, $x1, $x2, $y1, $y2)) {
            foreach ($aRows as $aTopic) {
                $aTopics[] = Engine::GetEntity('Topic', $aTopic);
            }
        }

        return $aTopics;
    }
}
