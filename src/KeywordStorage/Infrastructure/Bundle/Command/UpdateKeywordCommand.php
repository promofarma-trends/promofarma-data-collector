<?php

namespace KeywordStorage\Infrastructure\Bundle\Command;

use KeywordStorage\Application\ModifyKeywords;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateKeywordCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:keyword-storage:update')
            ->addArgument(
                'old_keyword',
                InputArgument::REQUIRED
            )
            ->addArgument(
                'new_keyword',
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
            '-> Updating keyword: ' .
                '<fg=red>' . $input->getArgument('old_keyword') . '</>' .
                ' to ' .
                '<fg=green>' . $input->getArgument('new_keyword') . '</>' .
                ' ...'
        ]);
        
        /** @var ModifyKeywords $keywordsManager */
        $keywordsManager = $this
            ->getContainer()
            ->get('keyword_storage.modify_keywords_use_case');
        $keywordsManager->updateOneByName(
            $input->getArgument('old_keyword'),
            $input->getArgument('new_keyword')
        );
        
        $output->writeln([
            '',
            '<fg=green>Keyword <fg=yellow>updated successfully!</>'
        ]);
    }
}