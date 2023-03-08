<?php

declare(strict_types=1);

namespace Application\Generator;

use Domain\Generator\PdfInterface;
use Knp\Snappy\Pdf as SnappyPdf;

class Pdf implements PdfInterface
{
    public function __construct(private readonly SnappyPdf $generator, private readonly array $options = [])
    {
    }

    public function generateFromUrl(string $url, bool $overwrite = true, array $options = []): string
    {
        $filename = tempnam(sys_get_temp_dir(), 'pdf');
        $this->generator->generate($url, $filename, $options ?? $this->options, $overwrite);

        return $filename;
    }

    public function generateFromHtml(string $html, bool $overwrite = true, array $options = []): string
    {
        $filename = tempnam(sys_get_temp_dir(), 'pdf');
        $this->generator->generateFromHtml($html, $filename, $options ?? $this->options, $overwrite);

        return $filename;
    }
}