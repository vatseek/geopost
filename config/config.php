<?php

$config = array(
    'tile_link' => 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    'map_copyright' => 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
);

Config::Set('router.geopost.map', 'PluginGeopost_ActionMap');

return $config;