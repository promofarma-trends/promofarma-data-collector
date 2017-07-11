<?php

namespace DataNormalizerBundle\Services;

use DataNormalizerBundle\Model\Post;
use DataNormalizerBundle\Model\PostInterface;
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
    public function normalize()
    {
        $uuid      = Uuid::generate();
        $content   = $this->instagramPost->getComment();
        $lang      = null;
        $media     = $this->instagramPost->getMediaSrc();
        $tags      = $this->instagramPost->getTags();
        $location  = null;
        $score     = $this->composeScore();
        $createdAt = DateTime::createFromFormat(
            'U',
            $this->instagramPost->getTakenAtTimestamp()
        );
        
        return new Post(
            $uuid,
            $content,
            $lang,
            [$media],
            $tags,
            $location,
            $score,
            $createdAt,
            'instagram'
        );
    }
    
    /**
     * @return Score
     */
    private function composeScore()
    {
        return Score::fromInteger(5);
    }
}