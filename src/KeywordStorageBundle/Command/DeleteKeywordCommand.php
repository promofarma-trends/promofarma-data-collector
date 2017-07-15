<?php


namespace KeywordStorageBundle\Command;

use KeywordStorageBundle\Services\ModifyKeywords;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteKeywordCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:keyword-storage:delete')
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
            '-> Deleting keyword...',
        ]);
    
        $keywords = $this->splitKeywords(
            $input->getArgument('keyword')
        );
        
        /** @var ModifyKeywords $keywordsManager */
        $keywordsManager = $this
            ->getContainer()
            ->get('keyword_storage.modify_keywords_use_case');
        $keywordsManager->deleteMany($keywords);
        
        $output->writeln([
            '',
            '<fg=green>Keyword(s) deleted successfully!</>'
        ]);
    }
    
    private function splitKeywords(string $keywordsString)
    {
        $cleanKeywordsString = str_replace(' ', '', $keywordsString);
        $keywordsArray =  explode(',', $cleanKeywordsString);
        
        return $keywordsArray;
    }
}