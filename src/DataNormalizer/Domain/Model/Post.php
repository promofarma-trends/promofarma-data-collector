<?php

namespace DataNormalizer\Domain\Model;

use DataNormalizer\Domain\Model\PostType\Location;
use DataNormalizer\Domain\Model\PostType\Score;
use DateTime;

/**
 * Class Post
 *
 * @package Bundle\Domain
 */
class Post
{
    /** @var string */
    private $uuid;
    
    /** @var string */
    private $content;
    
    /** @var string */
    private $lang;
    
    /** @var array */
    private $media;
    
    /** @var array */
    private $tags;
    
    /** @var Location|null */
    private $location;
    
    /** @var Score */
    private $score;
    
    /** @var DateTime */
    private $createdAt;
    
    /** @var string */
    private $source;
    
    /**
     * Post constructor.
     *
     * @param string        $uuid
     * @param string        $content
     * @param string        $lang
     * @param array         $media
     * @param array         $tags
     * @param Location|null $location
     * @param Score         $score
     * @param DateTime      $createdAt
     * @param string        $source
     */
    public function __construct(
        string $uuid,
        ? string $content,
        ? string $lang,
        array $media,
        array $tags,
        ? Location $location,
        Score $score,
        DateTime $createdAt,
        string $source
    )
    {
        $this->uuid      = $uuid;
        $this->content   = $content;
        $this->lang      = $lang;
        $this->media     = $media;
        $this->tags      = $tags;
        $this->location  = $location;
        $this->score     = $score;
        $this->createdAt = $createdAt;
        $this->source    = $source;
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'uuid'      => $this->uuid,
            'content'   => $this->content,
            'lang'      => $this->lang,
            'media'     => $this->media,
            'tags'      => $this->tags,
            'location'  => (null !== $this->location)
                ? $this->location->toArray()
                : null,
            'score'     => $this->score->get(),
            'created_at' => $this->createdAt,
            'source'    => $this->source,
        ];
    }
    
    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
    
    /** @return string */
    public function getUuid(): string
    {
        return $this->uuid;
    }
    
    /** @return null|string */
    public function getContent(): ? string
    {
        return $this->content;
    }
    
    /** @return null|string */
    public function getLang(): ? string
    {
        return $this->lang;
    }
    
    /** @return array */
    public function getMedia(): array
    {
        return $this->media;
    }
    
    /** @return array */
    public function getTags(): array
    {
        return $this->tags;
    }
    
    /** @return Location|null */
    public function getLocation(): ? Location
    {
        return $this->location;
    }
    
    /** @return Score */
    public function getScore(): Score
    {
        return $this->score;
    }
    
    /** @return DateTime */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    
    /** @return string */
    public function getSource(): string
    {
        return $this->source;
    }
}