<?php
/**
 * Created by PhpStorm.
 * User: alexhoma
 * Date: 30/05/2017
 * Time: 17:23
 */

namespace DataNormalizerBundle\Model\PostType;

use DataNormalizerBundle\Exception\NotValidScoreException;

/**
 * Class Score
 *
 * @package DataNormalizerBundle\Domain\PostType
 */
class Score
{
    private $score;
    
    private function __construct(int $score)
    {
        $this->ensureIsValidScore($score);
        
        $this->score = $score;
    }
    
    private function ensureIsValidScore(int $score)
    {
        if ($score > 10 || $score <= 0) {
            throw new NotValidScoreException(
                'Score must be an integer between 0 and 100'
            );
        }
    }
    
    public static function fromInteger(string $score): self
    {
        return new self($score);
    }
    
    
    /** @return integer */
    public function get(): int
    {
        return (integer) $this->score;
    }
}