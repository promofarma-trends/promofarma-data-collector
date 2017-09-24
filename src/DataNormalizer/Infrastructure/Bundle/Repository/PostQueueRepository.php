<?php

namespace DataNormalizer\Bundle\Repository\Repository;


/**
 * Interface SqsQueueRepository
 *
 * @package Bundle\Repository
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