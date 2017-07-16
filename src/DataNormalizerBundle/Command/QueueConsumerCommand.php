<?php

namespace DataNormalizerBundle\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface QueueConsumerCommand
{
    public function consume(
        InputInterface $input,
        OutputInterface $output,
        $payload
    );
}