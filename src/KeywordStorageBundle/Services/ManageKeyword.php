<?php

namespace KeywordStorageBundle\Services;

use KeywordStorageBundle\Entity\Keyword;
use KeywordStorageBundle\Entity\KeywordRepository;

/**
 * Class ManageKeyword
 *
 * @package KeywordStorageBundle\Services
 */
class ManageKeyword
{
    private $repository;
    
    public function __construct(KeywordRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function addOne(string $keyword)
    {
        if (!$this->checkIfKeywordExists($keyword)) {
            $keywordObject = new Keyword($keyword);
            $this->repository->create($keywordObject);
        }
        
        // silent pass
    }
    
    public function addMany(array $keywords)
    {
        foreach ($keywords as $keyword) {
            $this->addOne($keyword);
        }
    }
    
    public function deleteOne(string $keyword)
    {
        if ($keyword === '*') {
            $this->repository->deleteAll();
        }
        
        if ($keyword = $this->checkIfKeywordExists($keyword)) {
            $this->repository->delete($keyword);
        }
    }
    
    public function deleteMany(array $keywords)
    {
        foreach ($keywords as $keyword) {
            $this->deleteOne($keyword);
        }
    }
    
    public function updateOne(
        string $oldKeyword,
        string $newKeyword
    )
    {
        $keyword = $this->checkIfKeywordExists($oldKeyword);
        if ($keyword) {
            $keyword->setName($newKeyword);
            
            $this->repository->update($keyword);
        }
    }
    
    private function checkIfKeywordExists(string $keyword)
    {
        return $this->repository->findOneByName($keyword);
    }
}