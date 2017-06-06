<?php

namespace DataNormalizerBundle\Services;

use DataNormalizerBundle\Model\Post;
use DataNormalizerBundle\Model\PostInterface;
use DataNormalizerBundle\Model\PostType\Coordinates;
use DataNormalizerBundle\Model\PostType\Location;
use DataNormalizerBundle\Model\PostType\Score;
use DataNormalizerBundle\Model\PostType\Uuid;
use Mineur\TwitterStreamApi\Model\Tweet;
use DateTime;

/**
 * Class TwitterPostAdapter
 *
 * @package DataNormalizerBundle\Infrastructure
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
        $createdAt = new DateTime('now');
    
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
    
    private function composeLocation()
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
            $retweetsCount = $retweet->getRetweetCount();
            $favsCount = $retweet->getFavoriteCount();
            
            $score = ($userFollowers * 20) / 100; // 20% of user followers
        }
        
        return Score::fromInteger($score);
    }
}