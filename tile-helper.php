<?php

namespace TileHelper;

class Helper
{
}

class WMTS
{
    protected $_url;

    public function __construct($url)
    {
        $this->_url = $url;
    }

    public function latlngtopoint($lat, $lng, $zoom)
    {
        $pow = pow(2, $zoom);

        $sinLat = sin($lat * pi() / 180);

        $pixelX = floor(256 * ($lng + 180) * $pow / 360);
        $pixelY = floor(256 * $pow * (0.5 - log((1 + $sinLat) / (1 - $sinLat)) / (4 * pi())));

        return array(floor($pixelX / 256), floor($pixelY / 256), floor($pixelX) % 256, floor($pixelY) % 256);
    }

    public function getURL($x, $y, $zoom)
    {
        $url = $this->_url;
        $url = str_replace('{zoom}', $zoom, $url);
        $url = str_replace('{x}', $x, $url);
        $url = str_replace('{y}', $y, $url);
        return $url;
    }
}
