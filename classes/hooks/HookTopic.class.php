<?php

class PluginGeopost_HookTopic extends Hook
{
    public function RegisterHook()
    {
        $this->AddHook('template_form_add_topic_topic_end', 'TemplateFormAddTopicBegin', __CLASS__);
        $this->AddHook('template_form_add_topic_question_end', 'TemplateFormAddTopicBegin', __CLASS__);
        $this->AddHook('template_form_add_topic_link_end', 'TemplateFormAddTopicBegin', __CLASS__);
        $this->AddHook('template_form_add_topic_photoset_end', 'TemplateFormAddTopicBegin', __CLASS__);

        $this->AddHook('topic_add_after', 'TopicSubmitAfter', __CLASS__);
        $this->AddHook('topic_edit_after', 'TopicSubmitAfter', __CLASS__);

        $this->AddHook('template_main_menu_item', 'TemplateMainMenuItem', __CLASS__);
    }

    public function TemplateMainMenuItem()
    {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath('geopost') . 'main_menu_item.tpl');
    }

    public function TemplateFormAddTopicBegin()
    {
        $iTopicId = getRequest('topic_id');
        $oTopic = $this->Topic_GetTopicById($iTopicId);

        if ($oTopic) {
            $lat = $oTopic->getLat();
            $long = $oTopic->getLong();
        } else {
            $lat = 0;
            $long = 0;
        }
        $this->Viewer_Assign('geopost_lat', (float)$lat);
        $this->Viewer_Assign('geopost_long', (float)$long);

        return $this->Viewer_Fetch(Plugin::GetTemplatePath('geopost') . 'actions/ActionTopic/form_edit_topic.tpl');
    }

    public function TopicSubmitAfter($data)
    {
        $lat = (float) getRequest('lat', 0);
        $long = (float) getRequest('long', 0);

        if ($lat && $long) {
            $oTopic = $data['oTopic'];
            $oTopic->setLat($lat);
            $oTopic->setLong($long);

            $this->Topic_UpdateGeoData($oTopic);
        }
    }
}