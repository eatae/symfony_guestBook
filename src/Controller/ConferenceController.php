<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ConferenceController extends AbstractController
{

    /**
     * Index
     *
     * @param Request $request
     * @param string $name
     * @return Response
     */
    public function index(Request $request, string $name = ''): Response
    {
        $greet = '';
        if ($name) {
            $greet = sprintf('<h1>Hello %s!</h1>', htmlspecialchars($name));
        }
        dump($name);
        dump($request);
        return new Response(
            <<<EOF
            <html>
                <body>
                    $greet
                    <img src="/images/scheme.png" />
                </body>
            </html>
EOF
        );
    }

    /**
     * @return Response
     */
    public function indexOld(): Response
    {
        return $this->render('conference/index.html.twig', [
            'controller_name' => 'ConferenceController',
        ]);
    }
}
