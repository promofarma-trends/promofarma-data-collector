<?php

namespace KeywordStorage\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use KeywordStorage\Domain\Model\Keyword;
use KeywordStorage\Domain\Model\KeywordRepository;


class DoctrineKeywordRepository extends EntityRepository implements KeywordRepository
{
    /**
     * @{inheritdoc}
     */
    public function findOneByName(string $name)
    {
        return $this->findOneBy([
            'name' => $name
        ]);
    }
    
    /**
     * @{inheritdoc}
     */
    public function findOneById(int $id)
    {
        return $this->find($id);
    }
    
    /**
     * @{inheritdoc}
     */
    public function listAll()
    {
        return $this->findAll();
    }
    
    /**
     * @{inheritdoc}
     */
    public function create(Keyword $keyword)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($keyword);
        $entityManager->flush($keyword);
    }
    
    /**
     * @{inheritdoc}
     */
    public function update(Keyword $keyword)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->flush($keyword);
    }
    
    /**
     * @{inheritdoc}
     */
    public function delete(Keyword $keyword)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($keyword);
        $entityManager->flush($keyword);
    }
    
    /**
     * @{inheritdoc}
     */
    public function deleteAll()
    {
        $connection = $this->getEntityManager()->getConnection();
        $platform   = $connection->getDatabasePlatform();
    
        $connection->executeUpdate(
            $platform->getTruncateTableSQL('keywords', true)
        );
    }
}