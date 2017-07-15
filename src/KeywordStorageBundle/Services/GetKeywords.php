<?php

namespace KeywordStorageBundle\Services;

use KeywordStorageBundle\Entity\Keyword;
use KeywordStorageBundle\Entity\KeywordRepository;

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
        // @todo: implement method
    }
}