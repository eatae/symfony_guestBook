<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TestController extends AbstractController
{


    /**
     * @param Request $request
     * @param string $name
     * @return mixed
     */
    public function actionTest(Request $request, string $name) : Response
    {
        $testName = 'test'. ucfirst($name);
        $this->$testName($request);
        return new Response('<h5>'.$name.'</h5>');
    }



    public function testConnection(Request $request)
    {
        $conn = $this->getDoctrine()->getManager();
        dump($conn);
        exit;
    }

}
