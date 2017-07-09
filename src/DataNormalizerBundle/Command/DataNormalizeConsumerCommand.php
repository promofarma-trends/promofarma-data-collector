<?php

namespace DataNormalizerBundle\Command;


use DataNormalizerBundle\Services\InstagramPostAdapter;
use DataNormalizerBundle\Services\TwitterPostAdapter;
use RSQueue\Command\ConsumerCommand;
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
     * If many queues are defined, as Redis respects order of queues, you can
     * shuffle them just overwritting method shuffleQueues() and returning true
     *
     * @return boolean Shuffle before passing to Gearman
     */
    public function shuffleQueues()
    {
        return true;
    }
    
    /**
     * Consume method with retrieved queue value
     *
     * @param InputInterface  $input   An InputInterface instance
     * @param OutputInterface $output  An OutputInterface instance
     * @param Mixed           $payload Data retrieved and unserialized from
     *                                 queue
     */
    public function normalizeTweet(
        InputInterface $input,
        OutputInterface $output,
        $payload
    )
    {
        $tweet = unserialize($payload);
        
        dump(
            (new TwitterPostAdapter($tweet))->normalize()
        );
    }
    
    public function normalizeInstagramPost(
        InputInterface $input,
        OutputInterface $output,
        $payload
    )
    {
        $instagramPost = unserialize($payload);
        
        dump(
            (new InstagramPostAdapter($instagramPost))->normalize()
        );
    }
}