<?php

namespace DataNormalizerBundle\Model;

/**
 * Interface PostInterface
 *
 * @package DataNormalizerBundle\Domain
 */
interface PostInterface
{
    /**
     * @return mixed
     */
    public function normalize(): Post;
}