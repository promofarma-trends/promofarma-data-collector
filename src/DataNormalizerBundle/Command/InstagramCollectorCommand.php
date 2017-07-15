<?php

namespace DataNormalizerBundle\Command;


use KeywordStorageBundle\Services\GetKeywords;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstagramCollectorCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('collector:queue:produce-tweets');
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
        $keywordsList = $getKeywords->getAllToString();
        
        $command = $this
            ->getApplication()
            ->find('mineur:instagram-parser:consume');
        $input   = new ArrayInput([
            'keywords' => $keywordsList
        ]);
        
        $command->run($input, $output);
    }
}