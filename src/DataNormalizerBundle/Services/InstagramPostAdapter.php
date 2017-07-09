<?php

namespace DataNormalizerBundle\Services;

use DataNormalizerBundle\Model\Post;
use DataNormalizerBundle\Model\PostInterface;
use DataNormalizerBundle\Model\PostType\Coordinates;
use DataNormalizerBundle\Model\PostType\Location;
use DataNormalizerBundle\Model\PostType\Score;
use DataNormalizerBundle\Model\PostType\Uuid;
use DateTime;
use Mineur\InstagramParser\Model\InstagramPost;

/**
 * Class InstagramPostAdapter
 *
 * @package DataNormalizerBundle\Services
 */
class InstagramPostAdapter implements PostInterface
{
    /** @var InstagramPost */
    private $instagramPost;
    
    /**
     * TwitterPostAdapter constructor.
     *
     * @param InstagramPost $instagramPost
     */
    public function __construct(InstagramPost $instagramPost)
    {
        $this->instagramPost = $instagramPost;
    }
    
    /** @return Post */
    public function normalize(): Post
    {
        $uuid     = Uuid::generate();
        $content  = $this->instagramPost->getComment();
        $lang     = null;
        $media    = $this->instagramPost->getMediaSrc();
        $tags     = '';
        $location = $this->composeLocation();
        $score    = $this->composeScore();
        $createdAt = DateTime::createFromFormat(
            'U',
            $this->instagramPost->getTakenAtTimestamp()
        );
        
        return new Post(
            $uuid,
            $content,
            $lang,
            [$media],
            [$tags],
            $location,
            $score,
            $createdAt,
            'instagram'
        );
    }
    
    private function composeLocation()
    {
        return Location::fromArray(
            'city',
            'Los Angeles',
            'Los Angeles, California',
            'United States of America',
            'USA',
            Coordinates::fromLatLong(
                (float) 6.1234,
                (float) -5.2345
            )
        );
    }
    
    private function composeScore()
    {
        return Score::fromInteger(5);
    }
}