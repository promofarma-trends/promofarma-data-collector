<?php


namespace KeywordStorageBundle\Entity;


interface KeywordRepository
{
    /**
     * Find one keyword by name
     *
     * @param string $name
     * @return mixed
     */
    public function findOneByName(string $name);
    
    /**
     * List all keywords
     *
     * @return mixed
     */
    public function listAll();
    
    /**
     * Save one keyword
     *
     * @param Keyword $keyword
     * @return mixed
     */
    public function create(Keyword $keyword);
    
    /**
     * Update one keyword
     *
     * @param Keyword $keyword
     * @return mixed
     */
    public function update(Keyword $keyword);
    
    /**
     * Delete one keyword
     *
     * @param Keyword $keyword
     * @return mixed
     */
    public function delete(Keyword $keyword);
    
    /**
     * Truncate table
     *
     * @return mixed
     */
    public function deleteAll();
}