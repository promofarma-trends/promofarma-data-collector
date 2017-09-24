<?php

namespace DataNormalizer\Application;

use DataNormalizer\Domain\Model\Post;
use DataNormalizer\Domain\Model\PostInterface;
use DataNormalizer\Domain\Model\PostType\Coordinates;
use DataNormalizer\Domain\Model\PostType\Location;
use DataNormalizer\Domain\Model\PostType\Score;
use DataNormalizer\Domain\Model\PostType\Uuid;
use Mineur\TwitterStreamApi\Model\RetweetedStatus;
use Mineur\TwitterStreamApi\Model\Tweet;
use DateTime;

/**
 * Class TwitterPostAdapter
 *
 * @package Bundle\Bundles
 */
class TwitterPostAdapter implements PostInterface
{
    /** @var Tweet */
    private $tweet;
    
    /**
     * TwitterPostAdapter constructor.
     *
     * @param Tweet $tweet
     */
    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }
    
    /** @return Post */
    public function normalize(): Post
    {
        $uuid     = Uuid::generate();
        $content  = (null !== $this->tweet->getRetweetedStatus())
            ? $this->tweet->getRetweetedStatus()->getText()
            : $this->tweet->getText()
        ;
        $lang     = $this->tweet->getLang();
        $media    = $this->composeMedia();
        $tags     = $this->composeTags();
        $location = $this->composeLocation();
        $score    = $this->composeScore();
        $createdAt = DateTime::createFromFormat(
            'U',
            $this->tweet->getTimestampMs()
        );
    
        return new Post(
            $uuid,
            $content,
            $lang,
            $media,
            $tags,
            $location,
            $score,
            $createdAt,
            'twitter'
        );
    }
    
    private function composeLocation(): ? Location
    {
        $tweetPlace = $this->tweet->getPlaces();
        $tweetCoordinates = $this->tweet->getCoordinates();
        $coordinates = $tweetCoordinates['coordinates'];
        
        if (null === $tweetPlace && null ===$tweetCoordinates) {
            return null;
        }
        
        return Location::fromArray(
            $tweetPlace['place_type'],
            $tweetPlace['name'],
            $tweetPlace['full_name'],
            $tweetPlace['country'],
            $tweetPlace['country_code'],
            Coordinates::fromLatLong(
                $coordinates[0],
                $coordinates[1]
            )
        );
    }
    
    private function composeMedia()
    {
        $entities = $this->tweet->getEntities();
        $media = [];
        
        if (isset($entities['media'])) {
            foreach($entities['media'] as $item) {
                $media[] = $item['media_url'];
            }
        }
        
        return $media;
    }
    
    private function composeTags()
    {
        $entities = $this->tweet->getEntities();
        $tags = [];
        
        if (isset($entities['hashtags'])) {
            foreach($entities['hashtags'] as $hashtag) {
                $tags[] = $hashtag['text'];
            }
        }
        
        return $tags;
    }
    
    private function composeScore()
    {
        $score = 0;
        
        if (null !== $this->tweet->getRetweetedStatus()) {
            /** @var RetweetedStatus $retweet */
            $retweet = $this->tweet->getRetweetedStatus();
            $userFollowers = $retweet->getUser()->getFollowersCount();
            $favsCount = $retweet->getFavoriteCount();
            
            if (null !== $favsCount) {
                $score = ($favsCount / $userFollowers) * 10;
                // 10 is the max score you can earn by post
            }
        }
        
        if ($score < 0 || $score > 10) {
            $score = 0;
        }
        
        return Score::fromInteger(
            number_format((float)$score, 2, '.', '')
        );
    }
}