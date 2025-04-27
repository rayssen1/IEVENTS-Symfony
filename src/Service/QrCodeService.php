<?php

namespace App\Service;

use Endroid\QrCode\Builder\BuilderInterface;

class QrCodeService
{
    private BuilderInterface $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function createQrCode(string $data): string
    {
        $result = $this->builder
            ->data($data)
            ->build();

        return $result->getDataUri();
    }
}
