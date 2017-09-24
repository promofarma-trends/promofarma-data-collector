<?php

namespace DataNormalizer\Domain\Model\PostType;

use DataNormalizer\Domain\Exception\NotValidScoreException;

/**
 * Class Score
 *
 * @package Bundle\Domain\PostType
 */
class Score
{
    private $score;
    
    private function __construct(float $score)
    {
        $this->ensureIsValidScore($score);
        
        $this->score = $score;
    }
    
    private function ensureIsValidScore(float $score)
    {
        if ($score > 10 || $score < 0) {
            throw new NotValidScoreException(
                'Score must be an integer between 0 and 10'
            );
        }
    }
    
    public static function fromInteger(float $score): self
    {
        return new self((float) $score);
    }
    
    /** @return integer */
    public function get(): int
    {
        return (integer) $this->score;
    }
}