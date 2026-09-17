<?php

namespace App\Support;

final class MindanaoMap
{
    public const MIN_LATITUDE = 5.4;
    public const MAX_LATITUDE = 10.9;
    public const MIN_LONGITUDE = 120.6;
    public const MAX_LONGITUDE = 126.9;

    /**
     * Lightweight coastline approximation used to keep CMS pins scoped to
     * Mindanao without requiring a geocoding or maps API.
     *
     * Coordinates are [latitude, longitude] pairs in clockwise order.
     */
    public const POLYGON = [
        [7.0, 120.6],
        [7.8, 122.8],
        [8.7, 123.6],
        [9.1, 124.1],
        [9.8, 124.5],
        [10.2, 125.1],
        [10.6, 125.7],
        [10.7, 126.4],
        [10.3, 126.7],
        [9.5, 126.4],
        [9.0, 126.5],
        [8.5, 126.5],
        [7.8, 126.5],
        [7.2, 126.4],
        [6.6, 126.3],
        [6.0, 126.0],
        [5.5, 125.6],
        [5.6, 124.8],
        [6.0, 124.2],
        [6.2, 123.5],
        [6.4, 122.8],
        [6.0, 122.1],
        [6.7, 121.8],
    ];

    public static function contains(float|int|null $latitude, float|int|null $longitude): bool
    {
        if (! ($latitude !== null
            && $longitude !== null
            && $latitude >= self::MIN_LATITUDE
            && $latitude <= self::MAX_LATITUDE
            && $longitude >= self::MIN_LONGITUDE
            && $longitude <= self::MAX_LONGITUDE)) {
            return false;
        }

        $inside = false;
        $polygon = self::POLYGON;
        $vertexCount = count($polygon);

        for ($index = 0, $previous = $vertexCount - 1; $index < $vertexCount; $previous = $index++) {
            [$currentLatitude, $currentLongitude] = $polygon[$index];
            [$previousLatitude, $previousLongitude] = $polygon[$previous];

            $intersects = (($currentLongitude > $longitude) !== ($previousLongitude > $longitude))
                && ($latitude < (($previousLatitude - $currentLatitude)
                    * ($longitude - $currentLongitude)
                    / ($previousLongitude - $currentLongitude))
                    + $currentLatitude);

            if ($intersects) {
                $inside = ! $inside;
            }
        }

        return $inside;
    }
}
