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
    public function normalize(): Post
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
     * @todo: "this needs a better implementation
     *         We did it like this because we don't have access
     *         to the user followers to do a better calc"
     *
     * @return Score
     */
    private function composeScore()
    {
        $likesCount = $this->instagramPost->getLikesCount();
        $score = 0;
        
        if ($likesCount == 0) {
            $score = 0;
        }
        if ($likesCount > 0 && $likesCount <= 50) {
            $score = 1;
        }
        if ($likesCount > 50 && $likesCount <= 100) {
            $score = 2;
        }
        if ($likesCount > 100 && $likesCount <= 200) {
            $score = 3;
        }
        if ($likesCount > 200 && $likesCount <= 300) {
            $score = 4;
        }
        if ($likesCount > 300 && $likesCount <= 500) {
            $score = 5;
        }
        if ($likesCount > 500 && $likesCount <= 1000) {
            $score = 6;
        }
        if ($likesCount > 500 && $likesCount <= 1000) {
            $score = 7;
        }
        if ($likesCount > 1000 && $likesCount <= 5000) {
            $score = 8;
        }
        if ($likesCount > 5000 && $likesCount <= 10000) {
            $score = 9;
        }
        if ($likesCount > 10000) {
            $score = 10;
        }
        
        return Score::fromInteger(
            number_format((float)$score, 2, '.', '')
        );
    }
}