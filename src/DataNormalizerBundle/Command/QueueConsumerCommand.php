<?php

namespace DataNormalizerBundle\Command;


interface QueueConsumerCommand
{
    public function consume($payload);
}