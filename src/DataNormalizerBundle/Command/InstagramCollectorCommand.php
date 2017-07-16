<?php

namespace DataNormalizerBundle\Command;


use DateTime;
use KeywordStorageBundle\Services\GetKeywords;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstagramCollectorCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('data-collector:instagram-queue:produce')
            ->setDescription('
                Collects Instagram posts based on the Keywords
                Storage tags and enqueues the result into RSQueue.
            ')
        ;
    }
    
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    )
    {
        /** @var GetKeywords $getKeywords */
        $getKeywords  = $this
            ->getContainer()
            ->get('keyword_storage.get_keywords_use_case');
        $keyword = $getKeywords->getOneNotParsedBefore();
        
        $modifyKeyword = $this
            ->getContainer()
            ->get('keyword_storage.modify_keywords_use_case');
        $modifyKeyword->updateLastFetched(
            $keyword,
            new DateTime('now')
        );
    
        /**
         * Execute command
         */
        $command = $this
            ->getApplication()
            ->find('mineur:instagram-parser:enqueue');
        $input   = new ArrayInput([
            'keyword' => $keyword->getName()
        ]);
        $exitCode = $command->run($input, $output);
        dump($exitCode);
    }
}