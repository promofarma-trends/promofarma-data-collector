<?php

namespace KeywordStorageBundle\Entity;

use Symfony\Component\Validator\Constraints\DateTime;

class Keyword
{
    /** @var int */
    private $id;
    
    /** @var string */
    private $name;
    
    /** @var DateTime */
    private $lastFetch;
    
    /**
     * Keyword constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    /** @return int */
    public function getId(): int
    {
        return $this->id;
    }
    
    /** @return string */
    public function getName(): string
    {
        return $this->name;
    }
    
    /** @param string $name */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /** @return DateTime */
    public function getLastFetch(): DateTime
    {
        return $this->lastFetch;
    }
    
    /** @param DateTime $lastFetch */
    public function setLastFetch(DateTime $lastFetch)
    {
        $this->lastFetch = $lastFetch;
    }
}