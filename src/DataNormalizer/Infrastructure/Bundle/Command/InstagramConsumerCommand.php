<?php

namespace DataNormalizer\Infrastructure\Bundle\Command;

use DataNormalizer\Application\EnqueueNormalizedPost;
use DataNormalizer\Application\InstagramPostAdapter;
use RSQueue\Command\ConsumerCommand;
use RSQueue\Services\Consumer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
            ->setName('data-collector:instagram-queue:consume')
            ->setDescription('Consume Instagram posts from RSqueue and executes the Normalizer service.')
        ;
        
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
    
    public function consume(
        InputInterface $input,
        OutputInterface $output,
        $payload
    )
    {
        $output->writeln([
            '<fg=yellow> > RSqueue:</> Fetching Instagram post... </>',
            '   |'
        ]);
        
        $instagramPost = unserialize($payload);
        $post          = (new InstagramPostAdapter($instagramPost))->normalize();
        
        $output->writeln([
            '<fg=green>   √ Normalized -></> ' . $post->getUuid(),
            '   |'
        ]);
        
        $this->sqsEnqueue->enqueue($post);
    
        $output->writeln([
            '<fg=green>   √ Enqueued to SQS</>',
            ''
        ]);
    }
}