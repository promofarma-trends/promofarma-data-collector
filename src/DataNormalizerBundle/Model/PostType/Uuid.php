<?php

namespace DataNormalizerBundle\Model\PostType;

/**
 * Class Uuid
 *
 * @package DataNormalizerBundle\Domain\PostType
 */
class Uuid
{
    public static function generate()
    {
        return (string) md5(uniqid());
    }
}