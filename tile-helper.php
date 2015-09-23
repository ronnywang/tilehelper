<?php

namespace TileHelper;

class Helper
{
    /**
     * latLngDeltaPerMeter 取得在 $lat, $lng 時，每公尺是多少經緯度
     * 
     * @param mixed $lat 
     * @param mixed $lng 
     * @access public
     * @return void
     */
    public function latLngDeltaPerMeter($lat, $lng)
    {
        $earth_radius = 6378100;

        $lat_delta = 180 / ($earth_radius * pi()); 
        $lng_delta = 360 / (2 * pi() * $earth_radius * cos($lat * pi() / 180));

        return array($lat_delta, $lng_delta);
    }

    /**
     * gridPoint 把 ($lat, $lng) 降解析度到 ($lat_delta, $lng_delta)
     * 
     * @param mixed $lat 
     * @param mixed $lng 
     * @param mixed $lat_delta 
     * @param mixed $lng_delta 
     * @access public
     * @return void
     */
    public function gridPoint($lat, $lng, $lat_delta, $lng_delta)
    {
        return array(
            floor($lat / $lat_delta) * $lat_delta,
            floor($lng / $lng_delta) * $lng_delta,
        );
    }
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
