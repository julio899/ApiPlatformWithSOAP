<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SoapService extends AbstractController
{
    public function __construct()
    {
        global $kernel;

        $this->container = $kernel->getContainer();
        $this->apikey = $this->container->getParameter('apiKeyConexionService');
    }

    public function getApikey()
    {
        return $this->apikey;
    }

    public function getUserId()
    {
    }

    public function body()
    {
        $data_array = [
            '' => 'profile',
        ];

        $data_rol = [
            'developer' => 'rol',
            '31' => 'age',
            'male' => 'sex',
            'julio899@gmail.com' => 'email',
        ];

        $profile_props = [
                  'Julio' => 'name',
                  'Vinachi' => 'lastname',
                ];

        $xml = new \SimpleXMLElement('<app/>');
        array_walk_recursive($data_array, [$xml, 'addChild']);
        array_walk_recursive($data_rol, [$xml->profile, 'addChild']);
        array_walk_recursive($profile_props, [$xml->profile, 'addAttribute']);

        // Otra forma
        $xml->profile[0]->addChild('puntuacion', 'success');

        return $xml->asXML();
    }

    public function messageApikeyInvalid()
    {
        $data_array = [
            '' => 'response',
        ];

        $data_response = [
            '500' => 'code',
            'true' => 'error',
          ];

        $profile_props = [
                  'Julio Vinachi' => 'name-author',
                ];

        $xml = new \SimpleXMLElement('<app/>');
        array_walk_recursive($data_array, [$xml, 'addChild']);
        array_walk_recursive($data_response, [$xml->response, 'addChild']);
        array_walk_recursive($profile_props, [$xml->response, 'addAttribute']);

        // Otra forma
        $xml->response[0]->addChild('message', 'Error apikey is invalid');

        return $xml->asXML();
    }

    public function messageXmlInvalid()
    {
        $data_array = [
            '' => 'response',
        ];

        $data_response = [
            '500' => 'code',
            'true' => 'error',
          ];

        $profile_props = [
                  'Julio Vinachi' => 'name-author',
                ];

        $xml = new \SimpleXMLElement('<app/>');
        array_walk_recursive($data_array, [$xml, 'addChild']);
        array_walk_recursive($data_response, [$xml->response, 'addChild']);
        array_walk_recursive($profile_props, [$xml->response, 'addAttribute']);

        // Otra forma
        $xml->response[0]->addChild('message', 'Error the XML is Invalid or Break please check');

        return $xml->asXML();
    }

    public function setMessageCustom($code, $message, $err = 'true', $account = null)
    {
        $data_array = [
            '' => 'response',
        ];

        $data_response = [
            $code => 'code',
            $err => 'error',
          ];

        $profile_props = [
                  'Julio Vinachi' => 'name-author',
                ];

        $xml = new \SimpleXMLElement('<app/>');
        array_walk_recursive($data_array, [$xml, 'addChild']);
        array_walk_recursive($data_response, [$xml->response, 'addChild']);
        array_walk_recursive($profile_props, [$xml->response, 'addAttribute']);

        // Otra forma
        $xml->response[0]->addChild('message', $message);

        if (null != $account) {
            $xml->response[0]->addChild('account', $account['account']);
            $xml->response[0]->addChild('wallet', $account['wallet']);
        }

        return $xml->asXML();
    }

    public function clientIsValid($data_dom)
    {
        $isValid = false;
        $dom = new \DOMDocument();
        $dom->loadXML($data_dom);
        $client = \simplexml_import_dom($dom);

        if (isset($client->name) &&
                isset($client->lastname) &&
                isset($client->email) &&
                isset($client->document) &&
                isset($client->tdoc) &&
                isset($client->cellphone) &&
                '' != trim($client->name) &&
                '' != trim($client->lastname) &&
                '' != trim($client->email) &&
                '' != trim($client->document) &&
                '' != trim($client->tdoc) &&
                '' != trim($client->cellphone)
            ) {
            $isValid = true;
        }

        return $isValid;
    }

    public function clientLoginIsValid($data_dom)
    {
        $isValid = false;
        $dom = new \DOMDocument();
        $dom->loadXML($data_dom);
        $client = \simplexml_import_dom($dom);

        if (
                isset($client->email) &&
                isset($client->document) &&
                '' != trim($client->email) &&
                '' != trim($client->document)
            ) {
            $isValid = true;
        }

        return $isValid;
    }

    public function getDataClient($data_dom)
    {
        $dom = new \DOMDocument();
        $dom->loadXML($data_dom);
        $client = \simplexml_import_dom($dom);

        return [
            'name' => $client->name,
            'lastname' => $client->lastname,
            'email' => $client->email,
            'document' => $client->document,
            'tdoc' => $client->tdoc,
            'cellphone' => $client->cellphone,
        ];
    }

    public function getDataLogin($data_dom)
    {
        $dom = new \DOMDocument();
        $dom->loadXML($data_dom);
        $client = \simplexml_import_dom($dom);

        return [
            'email' => $client->email,
            'document' => $client->document,
        ];
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
