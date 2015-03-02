<script type="text/javascript">
    {literal}
    var tileLayerProviders = [];
    var tileProvider = '{/literal}{$oConfig->GetValue('plugin.geopost.tile_layers')}{literal}';
    var mapCopyright = '{/literal}{$oConfig->GetValue('plugin.geopost.map_copyright')}{literal}';
    {/literal}
    {foreach from=$oConfig->GetValue('plugin.geopost.tile_layers') item=tileData}
        {literal}
            tileLayerProviders.push({/literal}{$tileData|json_encode}{literal});
        {/literal}
    {/foreach}
</script>

