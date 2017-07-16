<?php

namespace KeywordStorageBundle\Services;


use DateTime;
use KeywordStorageBundle\Entity\Keyword;
use KeywordStorageBundle\Entity\KeywordRepository;

final class ModifyKeywords
{
    private $repository;
    
    public function __construct(KeywordRepository $repository)
    {
        $this->repository = $repository;
    }
    
    
    public function deleteOne(string $keyword)
    {
        if ($keyword === '*') {
            $this->repository->deleteAll();
        }
        
        if ($keyword = $this->repository->findOneByName($keyword)) {
            $this->repository->delete($keyword);
        }
    }
    
    public function deleteMany(array $keywords)
    {
        foreach ($keywords as $keyword) {
            $this->deleteOne($keyword);
        }
    }
    
    public function updateOneByName(
        string $oldKeyword,
        string $newKeyword
    )
    {
        $keyword = $this->repository->findOneByName($oldKeyword);
        
        if ($keyword) {
            $keyword->setName($newKeyword);
            
            $this->repository->update($keyword);
        }
    }
    
    public function updateLastFetched(
        Keyword $keyword,
        DateTime $dateTime
    )
    {
        /** @var Keyword $keyword */
        $keyword->setLastFetch($dateTime);
        
        $this->repository->update($keyword);
    }
}