<?php


namespace DataNormalizerBundle\Domain;

use DataNormalizerBundle\Domain\PostType\Content;
use DataNormalizerBundle\Domain\PostType\Image;
use DataNormalizerBundle\Domain\PostType\Language;
use DataNormalizerBundle\Domain\PostType\Location;
use DataNormalizerBundle\Domain\PostType\Score;
use DataNormalizerBundle\Domain\PostType\Uuid;
use DateTime;

/**
 * Class Post
 *
 * @package DataNormalizerBundle\Domain
 */
class Post
{
    private $uuid;
    private $content;
    private $lang;
    private $image;
//    private $location;
    private $score;
    private $createdAt;
    
    public function __construct(
        string $uuid,
        string $content,
        string $lang,
        string $image,
//        Location $location,
        Score $score,
        DateTime $createdAt
    )
    {
        $this->uuid = $uuid;
        $this->content = $content;
        $this->lang = $lang;
        $this->image = $image;
//        $this->location = $location;
        $this->score = $score;
        $this->createdAt = $createdAt;
    }
}