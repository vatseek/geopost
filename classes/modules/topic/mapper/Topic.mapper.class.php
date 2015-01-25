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
}
