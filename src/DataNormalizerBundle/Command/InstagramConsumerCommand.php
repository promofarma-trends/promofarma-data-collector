<?php

namespace DataNormalizerBundle\Command;


use DataNormalizerBundle\Services\EnqueueNormalizedPost;
use DataNormalizerBundle\Services\InstagramPostAdapter;
use RSQueue\Command\ConsumerCommand;
use RSQueue\Services\Consumer;

class InstagramConsumerCommand extends ConsumerCommand implements QueueConsumerCommand
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
            ->setName('collector:rsqueue:instagram:consume')
            ->setDescription('RSQueue consumer and normalizer Instagram posts command');
        
        parent::configure();
    }
    
    /**
     * Relates queue name with appropiated method
     */
    public function define()
    {
        $this->addQueue(
            'queues:instagram_posts',
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
        $instagramPost = unserialize($payload);
        $post          = (new InstagramPostAdapter($instagramPost))->normalize();
        
        $this->sqsEnqueue->enqueue($post);
    }
}