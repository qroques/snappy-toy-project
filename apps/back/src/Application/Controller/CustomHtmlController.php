<?php

declare(strict_types=1);

namespace Application\Controller;

use Domain\Generator\PdfInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CustomHtmlController extends AbstractController
{
    public function __construct(
        private readonly PdfInterface $pdf,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            return new BinaryFileResponse(
                $this->pdf->generateFromHtml(
                    html: $request->request->get('html'),
                    options: json_decode($request->request->get('options'), true)
                )
            );
        }

        return $this->render('custom-html.html.twig');
    }
}
