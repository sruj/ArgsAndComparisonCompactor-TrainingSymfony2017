<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ConsoleType;
use AppBundle\Args\Args;

class ArgsController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction(Request $request)
    {
        $inputPattern = '-l true -p 234 -d Ala';
        $commandInput = false;

        $form = $this->createForm(ConsoleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandData = $form->getData();
            $command = $commandData->getCommand();
            $schema = $commandData->getSchema();

            $args = new Args($schema, $command);
            $arguments = $args->getArguments();
            $array=[];
            foreach ($arguments as $letter => $object) {
                $array[$letter] = $args->getValueByLetter($letter);
            }

            return $this->render('args/results.html.twig', [
                'lettersWithValues' => $array,
                'command' => $command,
                'schema' => $schema,
            ]);
        }

        return $this->render('args/index.html.twig', [
            'inputPattern' => $inputPattern,
            'form' => $form->createView(),
            'commandInput' => $commandInput,
        ]);
    }

}

