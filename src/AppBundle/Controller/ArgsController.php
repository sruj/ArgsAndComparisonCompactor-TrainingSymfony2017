<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArgsController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction(Request $request)
    {
        $formString = '-l true -p 234 -d Ala';

        return $this->render('args/index.html.twig', [
            'mama' => $formString,
        ]);
    }
}

