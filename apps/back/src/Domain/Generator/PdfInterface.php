<?php

declare(strict_types=1);

namespace Domain\Generator;

interface PdfInterface
{
    public function generateFromUrl(string $url, bool $overwrite = true, array $options = []): string;

    public function generateFromHtml(string $html, bool $overwrite = true, array $options = []): string;
}
