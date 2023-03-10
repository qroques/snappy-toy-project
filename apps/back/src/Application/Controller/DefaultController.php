<?php

declare(strict_types=1);

namespace Application\Controller;

use Domain\Generator\PdfInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use HeadlessChromium\BrowserFactory;

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

        $browserFactory = new BrowserFactory();

        // starts headless chrome
        $browser = $browserFactory->createBrowser(['noSandbox' => true]);

        try {
            // creates a new page and navigate to an URL
            $page = $browser->createPage();
            $page->navigate($requestedUrl ?? $this->defaultUrl)->waitForNavigation();

            // // get page title
            // $pageTitle = $page->evaluate('document.title')->getReturnValue();

            // // screenshot - Say "Cheese"! 😄
            // $page->screenshot()->saveToFile('/foo/bar.png');

            // pdf
            $filename = tempnam(sys_get_temp_dir(), 'pdf');
            $page->pdf(['printBackground' => false])->saveToFile($filename);
        } finally {
            // bye
            $browser->close();
        }
        return new BinaryFileResponse(
            $filename
        );
    }
}
