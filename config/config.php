<?php

$config = array(
    'tile_link' => 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    'map_copyright' => 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
    'tile_layers' => array(
        array(
            'name' => 'Mapnik',
            'link' => 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'attributes' => array(
                'attribution' => '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            )
        ),
        array(
            'name' => 'Black and white',
            'link' => 'http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png',
            'attributes' => array(
                'attribution' => '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            )
        ),
        array(
            'name' => 'OpenCycleMap',
            'link' => 'http://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png',
            'attributes' => array(
                'attribution' => '&copy; <a href="http://www.opencyclemap.org">OpenCycleMap</a>, &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            )
        ),
    ),
);

Config::Set('router.page.map', 'PluginGeopost_ActionMap');

return $config;