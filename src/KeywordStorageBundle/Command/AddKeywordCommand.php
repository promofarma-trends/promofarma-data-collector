<?php

namespace KeywordStorageBundle\Command;

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
            '<fg=green>DATA COLLECTOR</>',
            '<fg=yellow>^^^^^^^^^^^^^^</>',
            '',
        ]);
    
        $keywords = $this->splitKeywords(
            $input->getArgument('keyword')
        );
        $userManager = $this->getContainer()->get('keyword_storage.manage_keywords_use_case');
        $userManager->addMany($keywords);
    
        $output->writeln('Keyword <fg=yellow></> added successfully!');
    }
    
    private function splitKeywords(string $keywordsString)
    {
        $cleanKeywordsString = str_replace(' ', '', $keywordsString);
        $keywordsArray =  explode(',', $cleanKeywordsString);
        
        return $keywordsArray;
    }
}