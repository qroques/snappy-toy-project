<?php

declare(strict_types=1);

namespace Application\Controller;

use Domain\Generator\PdfInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

final class DefaultController extends AbstractController
{
    public function __construct(
        private readonly PdfInterface $pdf,
        private readonly string $defaultUrl,
    )
    {
    }

    public function __invoke(string $requestedUrl = null): Response
    {
        return new BinaryFileResponse(
            $this->pdf->generateFromUrl($requestedUrl ?? $this->defaultUrl)
        );
    }
}
