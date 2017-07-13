<?php

namespace KeywordStorageBundle\Command;

use KeywordStorageBundle\Services\ManageKeyword;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IndexKeywordsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:keyword-storage:index-all');
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
            '-> Indexing all keywords ...',
        ]);
        
        $this->startIndexProcess($output);
        
        $output->writeln([
            '',
            '<fg=green>All Keywords indexed successfully!</>'
        ]);
    }
    
    /**
     * In order to get a cool progress bar
     * I index one by one :P
     */
    private function startIndexProcess($output)
    {
        $keywords = $this->getAllKeywords();
        $progress = new ProgressBar($output, count($keywords));
        $progress->start();
        
        foreach ($keywords as $keyword) {
            /** @var ManageKeyword $keywordsManager */
            $keywordsManager = $this
                ->getContainer()
                ->get('keyword_storage.manage_keywords_use_case');
            $keywordsManager->addOne($keyword);
        
            $progress->advance();
        }
        $progress->finish();
    }
    
    /**
     * In memory keywords array
     *
     * @return array
     */
    private function getAllKeywords()
    {
        return [
            'cremasolar',
            'cosmetica',
            'cosméticacorporal',
            'aceitesolar',
            'solares',
            'bronceado',
            'aceitecorporal',
            'biooil',
            'rosamosqueta',
            'anticeluliticos',
            'somatoline',
            'celulitis',
            'antiestrias',
            'estrias',
            'nomasestrias',
            'busto',
            'senos',
            'vientreplano',
            'pechos',
            'hidratación',
            'pielhidratada',
            'larocheposay',
            'eucerin',
            'pielseca',
            'piel',
            'pielatopica',
            'pielnormal',
            'pielsensible',
            'pielgrasa',
            'pielmixta',
            'pielmadura',
            'maquillaje',
            'covermark',
            'correctorojeras',
            'ojeras',
            'desmaquillante',
            'perfume',
            'desmaquillar',
            'colonia',
            'aguabrava',
            'berdoues',
            'rochas',
            'exfoliante',
            'vichy',
            'elifecosxir',
            'pielreafirmante',
            'talika',
            'sesderma',
            'acne',
            'limpiezafacial',
            'antiimperfecciones',
            'avene',
            'martiderm',
            'bioderma',
            'mascarilla',
            'maskrepair',
            'tónicofacial',
            'tónico',
            'antiedad',
            'antiage',
            'antiaging',
            'tratamientodia',
            'antimanchaspiel',
            'dermatitis',
            'sensilis',
            'eucerin',
            'seborreica',
            'cerposis',
            'exfoliante',
            'pieljoven',
            'revitalizante',
            'brochasdemaquillaje',
            'espejos',
            'imoaka',
            'purificante',
            'afeitar',
            'cortapelos',
            'tintes',
            'aftershave',
            'labial',
            'letibalm',
            'lapizdeojos',
            'sombrasdeojos',
            'difuminadordeojos',
            'belcils',
            'boho',
            'protecciónsolar',
            'solar',
            'proteccióncabello',
            'isdin',
            'fotoprotección',
            'fotoprotector',
            'higiene',
            'glucomentro',
            'glucometría',
            'tensiómetro',
            'accucheck',
            'visomat',
            'omron',
            'lancetas',
            'aromaterapia',
            'aceitesesenciales',
            'velas',
            'bulgarianrose',
            'botiquin',
            'antiparasitos',
            'golpes',
            'heridas',
            'mareo',
            'pastillero',
            'picadura',
            'quemadura',
            'mosquitos',
            'vaselina',
            'afterbite',
            'insectos',
            'colesterol',
        ];
    }
}