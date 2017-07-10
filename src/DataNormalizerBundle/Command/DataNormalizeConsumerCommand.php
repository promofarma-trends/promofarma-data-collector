<?php

namespace DataNormalizerBundle\Command;


use DataNormalizerBundle\Services\InstagramPostAdapter;
use DataNormalizerBundle\Services\EnqueueNormalizedPost;
use DataNormalizerBundle\Services\TwitterPostAdapter;
use RSQueue\Command\ConsumerCommand;
use RSQueue\Services\Consumer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DataNormalizerConsumerCommand
 *
 * @package DataNormalizerBundle\Command
 */
class DataNormalizeConsumerCommand extends ConsumerCommand
{
    /**
     * @var EnqueueNormalizedPost
     */
    private $sqsEnqueue;
    
    /**
     * DataNormalizeConsumerCommand constructor.
     *
     * @param Consumer              $consumer
     * @param EnqueueNormalizedPost $sqsEnqueue
     */
    public function __construct(
        Consumer $consumer,
        EnqueueNormalizedPost $sqsEnqueue
    )
    {
        parent::__construct($consumer);
        
        $this->sqsEnqueue = $sqsEnqueue;
    }
    
    /**
     * Configuration method
     */
    protected function configure()
    {
        $this
            ->setName('mineur:queue-consumer:normalize')
            ->setDescription('RSQueue Tweet consumer command');
        
        parent::configure();
    }
    
    /**
     * Relates queue name with appropiated method
     */
    public function define()
    {
        $this->addQueue(
            'queues:tweets',
            'normalizeTweet'
        );
        $this->addQueue(
            'queues:instagram_posts',
            'normalizeInstagramPost'
        );
    }
    
    /**
     * @{inheritdoc}
     */
    public function shuffleQueues()
    {
        return true;
    }
    
    public function normalizeTweet(
        InputInterface $input,
        OutputInterface $output,
        $payload
    )
    {
        $tweet = unserialize($payload);
        $post  = (new TwitterPostAdapter($tweet))->normalize();
        
        $this->sqsEnqueue->enqueue($post);
    }
    
    public function normalizeInstagramPost(
        InputInterface $input,
        OutputInterface $output,
        $payload
    )
    {
        $instagramPost = unserialize($payload);
        $post          = (new InstagramPostAdapter($instagramPost))->normalize();
        
        $this->sqsEnqueue->enqueue($post);
    }
}