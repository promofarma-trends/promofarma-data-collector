<?php

namespace DataNormalizer\Domain\Model\PostType;

/**
 * Class Uuid
 *
 * @package Bundle\Domain\PostType
 */
class Uuid
{
    public static function generate()
    {
        return (string) md5(uniqid());
    }
}