<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Services\SoapService;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\Clients;

class DefaultController extends AbstractController {

    private $apikey = null;
    private $SoapService = null;

    public function __construct()
    {
    	$this->SoapService = new SoapService();
		$this->apikey = $this->SoapService->getApikey();
    }

    /**
     * @Route("/", methods={"GET"}, name="home")
   	 */
	public function index(Request $request)
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/", methods={"POST"}, name="test_soap")
   	 */
    public function testSoap(Request $request)
    {
    	$response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');//ISO-8859-1

        $contentBody = $request->getContent();

    	if($request->headers->get('apikey') && $this->apikey == $request->headers->get('apikey') )
    	{

			// New obj DOM
			$dom = new \DOMDocument;
			$xml = @$dom->loadXML($contentBody);
    		
    		if($xml && $this->SoapService->clientIsValid($contentBody) )
    		{
        		$response->setContent( $contentBody );
    		}else{
				// case fomat invalid or break or format not client
    			$response->setContent( $this->SoapService->messageXmlInvalid() );
    		}    		

    	}else{
    		// case apikey invalid
    		$response->setContent( $this->SoapService->messageApikeyInvalid() );
    	}	
        
        return $response;    
    }
}