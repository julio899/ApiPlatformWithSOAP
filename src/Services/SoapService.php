<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SoapService extends AbstractController{
	
    public function __construct()
    {
    	global $kernel;
        $this->container = $kernel->getContainer();
        $this->apikey = $this->container->getParameter('apiKeyConexionService');
    }

    public function body()
    {

    	$data_array = array (
		  'Julio' => 'name',
		  'Vinachi' => 'lastname',
		  'another_array' => array (
		    'stack' => 'overflow',
		  ),
		);

		$xml = new \SimpleXMLElement('<app/>');
		array_walk_recursive($data_array, array ($xml, 'addChild'));
		return $xml->asXML();
    }
}