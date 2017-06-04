<?php

namespace DataNormalizerBundle\Services;

use DataNormalizerBundle\Domain\Post;
use DataNormalizerBundle\Domain\PostInterface;
use DataNormalizerBundle\Domain\PostType\Content;
use DataNormalizerBundle\Domain\PostType\Coordinates;
use DataNormalizerBundle\Domain\PostType\Image;
use DataNormalizerBundle\Domain\PostType\Language;
use DataNormalizerBundle\Domain\PostType\Location;
use DataNormalizerBundle\Domain\PostType\Score;
use DataNormalizerBundle\Domain\PostType\Uuid;
use DateTime;
use Mineur\TwitterStreamApi\Tweet;

/**
 * Class TwitterPostAdapter
 *
 * @package DataNormalizerBundle\Infrastructure
 */
class TwitterPostAdapter implements PostInterface
{
    private $tweet;
    
    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }
    
    /**
     * @return Post
     */
    public function normalize()
    {
        $uuid     = Uuid::generate();
        $content  = $this->tweet->getText();
        $lang     = $this->tweet->getLang();
        $image    = 'http://placehold.it/350x150';
//        $location = Location::fromArray(
//            'Barcelona',
//            'Spain',
//            Coordinates::fromLatLong(
//                floatval('12,12312312'),
//                floatval('-34,3231231')
//            )
//        );
        $score     = Score::fromInteger(3);
        $createdAt = new DateTime('now');
    
        return new Post(
            $uuid,
            $content,
            $lang,
            $image,
//            $location,
            $score,
            $createdAt
        );
    }
}