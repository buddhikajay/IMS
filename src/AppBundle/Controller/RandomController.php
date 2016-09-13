<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// todo check & remove
class RandomController extends Controller
{

    public function numberAction()
    {
        $data = array(
            'lucky_number' => rand(0, 100),
        );

        return new Response(
            json_encode($data),
            200,
            array('Content-Type' => 'application/json')
        );
    }

}
