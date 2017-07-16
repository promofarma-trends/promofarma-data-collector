<?php

namespace DataNormalizerBundle\Model\PostType;

/**
 * Class Location
 *
 * @package DataNormalizerBundle\Domain\PostType
 */
class Location
{
    /** @var string */
    private $type;
    
    /** @var string */
    private $name;
    
    /** @var string */
    private $fullName;
    
    /** @var string */
    private $country;
    
    /** @var string */
    private $countryCode;
    
    /** @var Coordinates */
    private $coordinates;
    
    /**
     * Location constructor.
     *
     * @param string      $type
     * @param string      $name
     * @param string      $fullName
     * @param string      $country
     * @param string      $countryCode
     * @param Coordinates $coordinates
     */
    private function __construct(
        ? string $type,
        ? string $name,
        ? string $fullName,
        ? string $country,
        ? string $countryCode,
        ? Coordinates $coordinates
    )
    {
        $this->type        = $type;
        $this->name        = $name;
        $this->fullName    = $fullName;
        $this->country     = $country;
        $this->countryCode = $countryCode;
        $this->coordinates = $coordinates;
    }
    
    /**
     * Construct location from array
     *
     * @param string      $type
     * @param string      $name
     * @param string      $fullName
     * @param string      $country
     * @param string      $countryCode
     * @param Coordinates $coordinates
     * @return Location
     */
    public static function fromArray(
        ? string $type,
        ? string $name,
        ? string $fullName,
        ? string $country,
        ? string $countryCode,
        ? Coordinates $coordinates
    ): self
    {
        return new self(
            $type,
            $name,
            $fullName,
            $countryCode,
            $country,
            $coordinates
        );
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'type'         => $this->type,
            'name'         => $this->name,
            'full_name'    => $this->fullName,
            'country_code' => $this->countryCode,
            'country'      => $this->country,
            'coordinates'  => (null !== $this->coordinates)
                ? $this->coordinates->toArray()
                : null
        ];
    }
    
    /** @return string */
    public function getType(): ? string
    {
        return $this->type;
    }
    
    /** @return string */
    public function getName(): ? string
    {
        return $this->name;
    }
    
    /** @return string */
    public function getFullName(): ? string
    {
        return $this->fullName;
    }
    
    /** @return string */
    public function getCountry(): ? string
    {
        return $this->country;
    }
    
    /** @return string */
    public function getCountryCode(): ? string
    {
        return $this->countryCode;
    }
    
    /** @return Coordinates */
    public function getCoordinates(): ? Coordinates
    {
        return $this->coordinates;
    }
}