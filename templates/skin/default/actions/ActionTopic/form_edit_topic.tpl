<p>
    <div id="map_form_container">
        <div id="map_edit" class="geopost-topic-edit"></div>
        <input type="hidden" value="{$geopost_lat}" name="lat"/>
        <input type="hidden" value="{$geopost_long}" name="long"/>
    </div>
</p>
{include file=$aTemplatePathPlugin.geopost|cat:'js_vars.tpl'}