<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		$defaultData = array('message' => 'Importe para retirar');
		$form = $this->createFormBuilder($defaultData)
			->add('importe', 'text')
			->getForm();

		$form->handleRequest($request);

		$error="";$notas=[];
		if ($form->isValid()) {
			// data is an array with "importe"
			$data = $form->getData();
			if($data['importe']>0){
				//Notas disponíveis de R$ 100,00; R$ 50,00; R$ 20,00 e R$ 10,00
				$notas100=intval($data['importe']/100);
				$rest=$data['importe']%100;
				$notas50=intval($rest/50);
				$rest=$rest%50;
				$notas20=intval($rest/20);
				$rest=$rest%20;
				$notas10=intval($rest/10);
				$rest=$rest%10;
				if($rest==0){
					$notas=[$notas100,$notas50,$notas20,$notas10];
				}else $error='Notas Indisponibles';
			}else $error='Importe Inválido';
		}


		return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),'error' => $error,'notas' => $notas
        ));
    }
}
