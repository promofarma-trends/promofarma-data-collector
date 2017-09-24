<?php

namespace DataNormalizer\Domain\Model;

/**
 * Interface PostInterface
 *
 * @package Bundle\Domain
 */
interface PostInterface
{
    /**
     * @return mixed
     */
    public function normalize(): Post;
}