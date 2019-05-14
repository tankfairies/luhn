<?php

namespace Luhn\Generator;

interface GeneratorInterface
{
    public function generate(): void;
    public function setLength(int $length): void;
    public function getToken(): string;
}
