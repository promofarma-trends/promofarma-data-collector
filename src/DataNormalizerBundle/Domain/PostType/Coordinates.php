<?php

namespace DataNormalizerBundle\Domain\PostType;

/**
 * Class Coordinates
 *
 * @package DataNormalizerBundle\Domain\PostType
 */
class Coordinates
{
    /** @var float */
    private $latitude;
    
    /** @var float */
    private $longitude;
    
    private function __construct(
        float $latitude,
        float $longitude
    )
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
    
    public static function fromLatLong(
        float $latitude,
        float $longitude
    )
    {
        return new self(
            $latitude,
            $longitude
        );
    }
}