<?php

namespace KeywordStorage\Application;

use KeywordStorage\Domain\Model\Keyword;
use KeywordStorage\Domain\Model\KeywordRepository;

final class CreateKeywords
{
    private $repository;
    
    public function __construct(KeywordRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function addOne(string $keyword)
    {
        if (!$this->repository->findOneByName($keyword)) {
            $keywordObject = new Keyword($keyword);
            $this->repository->create($keywordObject);
        }
    }
    
    public function addMany(array $keywords)
    {
        foreach ($keywords as $keyword) {
            $this->addOne($keyword);
        }
    }
}