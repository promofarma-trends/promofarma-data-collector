<?php

namespace KeywordStorageBundle\Command;

use KeywordStorageBundle\Services\CreateKeywords;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddKeywordCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:keyword-storage:add')
            ->addArgument(
                'keyword',
                InputArgument::REQUIRED
            );
    }
    
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    )
    {
        $output->writeln([
            '',
            '<fg=green>Keyword Storage Manager</>',
            '<fg=yellow>=======================</>',
            '',
            '-> Adding keywords...',
        ]);
    
        $keywords = $this->splitKeywords(
            $input->getArgument('keyword')
        );
        
        /** @var CreateKeywords $keywordsManager */
        $keywordsManager = $this
            ->getContainer()
            ->get('keyword_storage.create_keywords_use_case');
        $keywordsManager->addMany($keywords);
    
        $output->writeln([
            '',
            '<fg=green>Keyword(s) added successfully!</>'
        ]);
    }
    
    private function splitKeywords(string $keywordsString)
    {
        $cleanKeywordsString = str_replace(' ', '', $keywordsString);
        $keywordsArray =  explode(',', $cleanKeywordsString);
        
        return $keywordsArray;
    }
}