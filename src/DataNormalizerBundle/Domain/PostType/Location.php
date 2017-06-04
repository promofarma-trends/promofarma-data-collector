<?php

namespace DataNormalizerBundle\Domain\PostType;

/**
 * Class Location
 *
 * @package DataNormalizerBundle\Domain\PostType
 */
class Location
{
    private $location;
    
    private function __construct(array $location)
    {
        $this->location = $location;
    }
    
    public static function fromArray(
        string $name,
        string $country,
        Coordinates $coordinates
    ) : self
    {
        return new self($location);
    }
    
}