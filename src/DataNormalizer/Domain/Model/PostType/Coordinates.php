<?php

namespace DataNormalizer\Domain\Model\PostType;

/**
 * Class Coordinates
 *
 * @package Bundle\Domain\PostType
 */
class Coordinates
{
    /** @var float */
    private $latitude;
    
    /** @var float */
    private $longitude;
    
    /**
     * Coordinates constructor.
     *
     * @param float $latitude
     * @param float $longitude
     */
    private function __construct(
        ? float $latitude,
        ? float $longitude
    )
    {
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
    }
    
    /**
     * Create from latitude and longitude
     *
     * @param float $latitude
     * @param float $longitude
     * @return Coordinates
     */
    public static function fromLatLong(
        ? float $latitude,
        ? float $longitude
    )
    {
        return new self(
            $latitude,
            $longitude
        );
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }
    
    /** @return float */
    public function getLatitude(): ? float
    {
        return $this->latitude;
    }
    
    /** @return float */
    public function getLongitude(): ? float
    {
        return $this->longitude;
    }
}