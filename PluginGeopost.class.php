<?php
/*-------------------------------------------------------
*
*   LiveStreet Plugin Geopost
*   Copyright © 2008 Vadim Gumennyj
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: vadim.gumennyj@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

class PluginGeopost extends Plugin
{
    protected $aInherits = array(
        'action' => array(
            'ActionAjax' => '_ActionAjax',
        ),
        'module' => array(
            'ModuleTopic' => '_ModuleTopic',
        ),
        'entity' => array(
            'ModuleTopic_EntityTopic' => '_ModuleTopic_EntityTopic',
        ),
        'mapper' => array(
            'ModuleTopic_MapperTopic' => '_ModuleTopic_MapperTopic',
        ),
    );

    public function Activate()
    {
        if (!$this->isFieldExists(Config::Get('db.table.topic'), 'long')) {
            $this->ExportSQL(dirname(__FILE__) . '/install.sql');
        }

        return true;
    }

    /**
     * Инициализация плагина
     */
    public function Init()
    {
        $this->Viewer_Assign('sGeoPostPluginPath', Plugin::GetTemplatePath(__CLASS__));

        $this->Viewer_AppendScript('http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js');
        $this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__) . 'js/geopost.js');
        $this->Viewer_AppendStyle('http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css');
        $this->Viewer_AppendStyle(Plugin::GetTemplateWebPath(__CLASS__) . 'css/geopost.css');
    }
}