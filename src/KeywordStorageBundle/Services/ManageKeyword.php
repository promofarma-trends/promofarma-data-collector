<?php

namespace KeywordStorageBundle\Services;

use KeywordStorageBundle\Entity\Keyword;
use KeywordStorageBundle\Entity\KeywordRepository;

final class ManageKeyword
{
    private $repository;
    
    public function __construct(KeywordRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function addOne(string $keyword)
    {
        $keywordObject = new Keyword($keyword);
        
        $this->repository->save($keywordObject);
    }
    
    public function addMany(array $keywords)
    {
        foreach ($keywords as $keyword) {
            $this->addOne($keyword);
        }
    }
}