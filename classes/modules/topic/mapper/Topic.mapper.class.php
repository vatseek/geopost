<?php

class PluginGeopost_ModuleTopic_MapperTopic extends PluginGeopost_Inherit_ModuleTopic_MapperTopic
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

    public function getTopicsIdByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY)
    {
        $x1 = min($iTopLeftX, $iBotRightX);
        $x2 = max($iTopLeftX, $iBotRightX);
        $y1 = min($iTopLeftY, $iBotRightY);
        $y2 = max($iTopLeftY, $iBotRightY);

        $sql = "SELECT
                  _t.topic_id
                FROM " . Config::Get('db.table.topic') . " AS _t
                WHERE
                    _t.lat >= ?f
                    AND _t.lat < ?f
                    AND _t.long >= ?f
                    AND _t.long < ?f
                    AND _t.topic_publish = 1 ";

        $aTopicsId = array();
        if ($aRows = $this->oDb->select($sql, $x1, $x2, $y1, $y2)) {
            foreach ($aRows as $aTopic) {
                $aTopicsId[] = $aTopic['topic_id'];
            }
        }

        return $aTopicsId;
    }

    /**
     * @param $aZones
     *
     * @return array
     */
    public function getTopicsIdZones(array $aZones)
    {
        if (!$aZones) {
            return array();
        }

        $sql = "SELECT
                  _t.topic_id,
                  _t.lat,
                  _t.long
                FROM " . Config::Get('db.table.topic') . " AS _t
                WHERE
                    _t.topic_publish = 1
                    ";

        $sSubQuery = "AND (";
        foreach ($aZones as $aZone) {
            $iX1 = (int)$aZone['x'];
            $iX2 = (int)$aZone['x'] + 1;
            $iY1 = (int)$aZone['y'];
            $iY2 = (int)$aZone['y'] + 1;

            $sSubQuery .= " ( _t.lat >= " . $iX1 . "
                    AND _t.lat < " . $iX2 . "
                    AND _t.long >= " . $iY1 . "
                    AND _t.long < " . $iY2 . ") OR ";
        }

        $sql .= rtrim($sSubQuery, 'OR ') . ');';

        $aTopicZones = array();
        if ($aRows = $this->oDb->select($sql)) {
            foreach ($aRows as $aTopic) {
                foreach ($aZones as $aZone) {
                    if ($aZone['x'] == floor($aTopic['lat']) && $aZone['y'] == floor($aTopic['long'])) {
                        $aTopicZones[$aZone['x'] . '_' . $aZone['y']][] = $aTopic['topic_id'];
                    }
                }
            }
        }

        return $aTopicZones;
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
