<?php

namespace DataProcessorBundle\Command;


use RSQueue\Command\ConsumerCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestConsumerCommand extends ConsumerCommand
{
    /**
     * Configuration method
     */
    protected function configure()
    {
        $this
            ->setName('TEST')
            ->setDescription('Testing consumer command');
        ;
        
        parent::configure();
    }
    
    /**
     * Relates queue name with appropiated method
     */
    public function define()
    {
        $this->addQueue('videos', 'consumeVideo');
    }
    
    /**
     * If many queues are defined, as Redis respects order of queues, you can shuffle them
     * just overwritting method shuffleQueues() and returning true
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
     * @param Mixed           $payload Data retrieved and unserialized from queue
     */
    protected function consumeVideo(InputInterface $input, OutputInterface $output, $payload)
    {
        $output->writeln($payload);
    }
}