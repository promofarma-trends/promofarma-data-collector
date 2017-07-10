<?php

namespace DataNormalizerBundle\Repository;


/**
 * Interface SqsQueueRepository
 *
 * @package DataNormalizerBundle\Repository
 */
interface PostQueueRepository
{
    /**
     * @param string $queueId
     * @param string $message
     * @return mixed
     */
    public function send(
        string $queueId,
        string $message
    );
}