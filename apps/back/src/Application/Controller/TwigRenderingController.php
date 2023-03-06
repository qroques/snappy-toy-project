<?php

declare(strict_types=1);

namespace Application\Controller;

use Domain\Generator\PdfInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

final class TwigRenderingController extends AbstractController
{
    public function __construct(
        private readonly PdfInterface $pdf,
    )
    {
    }

    public function __invoke(): Response
    {
        $content = $this->renderView(
            'twig-rendering.html.twig'
        );
// return new Response($content);
//         dump($content);
        return new BinaryFileResponse(
            $this->pdf->generateFromHtml($content)
        );
    }
}
