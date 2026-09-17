<?php

namespace App\Support;

final class MindanaoMap
{
    public const MIN_LATITUDE = 4.3;
    public const MAX_LATITUDE = 10.9;
    public const MIN_LONGITUDE = 118.4;
    public const MAX_LONGITUDE = 126.9;

    public static function contains(float|int|null $latitude, float|int|null $longitude): bool
    {
        return $latitude !== null
            && $longitude !== null
            && $latitude >= self::MIN_LATITUDE
            && $latitude <= self::MAX_LATITUDE
            && $longitude >= self::MIN_LONGITUDE
            && $longitude <= self::MAX_LONGITUDE;
    }
}
