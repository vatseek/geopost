<?php

class PluginGeopost_HookTopic extends Hook
{
    public function RegisterHook()
    {
        $this->AddHook('template_form_add_topic_topic_begin', 'TemplateFormAddTopicBegin', __CLASS__);
        $this->AddHook('template_form_add_topic_question_begin', 'TemplateFormAddTopicBegin', __CLASS__);
        $this->AddHook('template_form_add_topic_link_begin', 'TemplateFormAddTopicBegin', __CLASS__);
        $this->AddHook('template_form_add_topic_photoset_begin', 'TemplateFormAddTopicBegin', __CLASS__);

        $this->AddHook('topic_add_after', 'TopicSubmitAfter', __CLASS__);
        $this->AddHook('topic_edit_after', 'TopicSubmitAfter', __CLASS__);

    }

    public function TemplateFormAddTopicBegin()
    {
        $iTopicId = getRequest('topic_id');
        $oTopic = $this->Topic_GetTopicById($iTopicId);

        if ($oTopic) {

        } else {

        }

        return $this->Viewer_Fetch(Plugin::GetTemplatePath('geopost') . 'actions/ActionTopic/form_edit_topic.tpl');
    }

    public function TopicSubmitAfter($data)
    {
        $oTopic = $data['oTopic'];
    }
}