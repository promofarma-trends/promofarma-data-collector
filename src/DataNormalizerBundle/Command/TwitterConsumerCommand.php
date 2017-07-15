<?php

namespace DataNormalizerBundle\Command;


use DataNormalizerBundle\Services\EnqueueNormalizedPost;
use DataNormalizerBundle\Services\TwitterPostAdapter;
use RSQueue\Command\ConsumerCommand;
use RSQueue\Services\Consumer;

/**
 * Class DataNormalizerConsumerCommand
 *
 * @package DataNormalizerBundle\Command
 */
class TwitterConsumerCommand extends ConsumerCommand implements QueueConsumerCommand
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
            ->setName('data-collector:twitter-queue:consume')
            ->setDescription('Consume Twitter posts from RSqueue and executes the Normalizer service.')
        ;
        
        parent::configure();
    }
    
    /**
     * Relates queue name with appropiated method
     */
    public function define()
    {
        $this->addQueue(
            'queues:tweets',
            'consume'
        );
    }
    
    /**
     * @{inheritdoc}
     */
    public function shuffleQueues()
    {
        return true;
    }
    
    public function consume($payload)
    {
        $tweet = unserialize($payload);
        $post  = (new TwitterPostAdapter($tweet))->normalize();
        
        $this->sqsEnqueue->enqueue($post);
    }
}