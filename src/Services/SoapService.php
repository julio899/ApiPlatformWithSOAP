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

    public function getApikey(){
    	return $this->apikey;
    }

    public function body()
    {

    	$data_array = array (
		    '' => 'profile'
		);
    	
    	$data_rol = array (
		    'developer' => 'rol',
		    '31' => 'age',
		    'male' => 'sex',
		    'julio899@gmail.com' => 'email'
		);

		$profile_props = [
				  'Julio' => 'name',
				  'Vinachi' => 'lastname'
    			];

		$xml = new \SimpleXMLElement('<app/>');
		array_walk_recursive($data_array, array ($xml, 'addChild'));
		array_walk_recursive($data_rol, array ($xml->profile, 'addChild'));
		array_walk_recursive($profile_props, array ($xml->profile, 'addAttribute'));

		// Otra forma
		$xml->profile[0]->addChild('puntuacion', 'success');

		return $xml->asXML();
    }

    public function messageApikeyInvalid()
    {

    	$data_array = array (
		    '' => 'response'
		);
    	
    	$data_response = array (
		    '500' => 'code',
		    'true' => 'error',
		  );

		$profile_props = [
				  'Julio Vinachi' => 'name-author'
    			];

		$xml = new \SimpleXMLElement('<app/>');
		array_walk_recursive($data_array, array ($xml, 'addChild'));
		array_walk_recursive($data_response, array ($xml->response, 'addChild'));
		array_walk_recursive($profile_props, array ($xml->response, 'addAttribute'));

		// Otra forma
		$xml->response[0]->addChild('message', 'Error apikey is invalid');

		return $xml->asXML();
    }

    public function messageXmlInvalid()
    {

    	$data_array = array (
		    '' => 'response'
		);
    	
    	$data_response = array (
		    '500' => 'code',
		    'true' => 'error',
		  );

		$profile_props = [
				  'Julio Vinachi' => 'name-author'
    			];

		$xml = new \SimpleXMLElement('<app/>');
		array_walk_recursive($data_array, array ($xml, 'addChild'));
		array_walk_recursive($data_response, array ($xml->response, 'addChild'));
		array_walk_recursive($profile_props, array ($xml->response, 'addAttribute'));

		// Otra forma
		$xml->response[0]->addChild('message', 'Error the XML is Invalid or Break please check');

		return $xml->asXML();
    }

    public function clientIsValid($data_dom){
    	$isValid = false;
		$dom = new \DOMDocument;
		$dom->loadXML($data_dom);
		$client = \simplexml_import_dom($dom);
		
		if( 	isset($client->name) && 
				isset($client->lastname) && 
				isset($client->email) && 
				isset($client->document) && 
				isset($client->tdoc) && 
				isset($client->cellphone) )
		{
			$isValid = true;
		}
		
		return $isValid;
    }


    /*
    	* Ejemplo para comprobacion de xml
    	$dom = new DOMDocument;
		$dom->loadXML('<libros><libro><titulo>bla</titulo></libro></libros>');
		if (!$dom) {
		    echo 'Error al analizar el documento');
		    exit;
		}

		$s = simplexml_import_dom($dom);

		echo $s->libro[0]->titulo;


		--------------------------------------------------

		* Notas de funcones disponibles
		SimpleXMLElement::addAttribute — Añade un atributo al elemento SimpleXML
		SimpleXMLElement::addChild — Añade un elemento hijo al nodo XML
		SimpleXMLElement::asXML — Retorna un string XML correcto basado en un elemento SimpleXML
		SimpleXMLElement::attributes — Identifica el atributo de un elemento
		SimpleXMLElement::children — Encuentra los hijos del nodo dado
		SimpleXMLElement::__construct — Crea un nuevo objeto SimpleXMLElement
		SimpleXMLElement::count — Cuenta los hijos de un elemento
		SimpleXMLElement::getDocNamespaces — Devuelve los espacios de nombre declarados en el documento
		SimpleXMLElement::getName — Retorna el nombre del elemento XML
		SimpleXMLElement::getNamespaces — Devuelve los espacios de nombre usados en el documento
		SimpleXMLElement::registerXPathNamespace — Crea un contexto prefijo/ns para la siguiente petición XPath
		SimpleXMLElement::saveXML — Alias de SimpleXMLElement::asXML
		SimpleXMLElement::__toString — Returns the string content
		SimpleXMLElement::xpath — Ejecuta una petición XPath sobre los datos XML
    */
}