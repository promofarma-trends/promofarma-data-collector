<?php

namespace KeywordStorage\Application;


use KeywordStorage\Domain\Model\Keyword;
use KeywordStorage\Domain\Model\KeywordRepository;

final class GetKeywords
{
    private $repository;
    
    public function __construct(KeywordRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function getAllToString(): string
    {
        $keywordsObjectArray = $this->repository->listAll();
        
        $keywordsArray = array_map(function($keyword) {
            /** @var Keyword $keyword */
            return $keyword->getName();
        }, $keywordsObjectArray);

        return implode(',', $keywordsArray);
    }
    
    public function getOneNotParsedBefore()
    {
        $all = count($this->repository->listAll());
        
        $id = rand(0, $all);
        /** @var Keyword $keyword */
        $keyword = $this
            ->repository
            ->findOneById($id);
        
        while($keyword->getLastFetch() !== null) {
            $keyword = $this
                ->repository
                ->findOneById($id);
        }
        
        return $keyword;
    }
}