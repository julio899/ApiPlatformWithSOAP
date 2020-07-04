<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Services\SoapService;
use App\Entity\Clients;
use App\Entity\Wallets;

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
     * @Route("/v1/register", methods={"POST"}, name="register_soap")
   	 */
    public function registerSoap(Request $request)
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
    			$em = $this->getDoctrine()->getManager();
    			$dataClient = $this->SoapService->getDataClient($contentBody);

		        $checkDocumet = $em->getRepository(Clients::class)->findBy(['document' => $dataClient['document'] ],['id' => 'DESC']);
		        
		        if(count($checkDocumet) > 0){
					// case exist other client with the same numer document
	    			$response->setContent( $this->SoapService->setMessageCustom(406,'Error ya existe un cliente registrado con el mismo nro de documento') );
	    			
	    			// 406 - Not Acceptable
	    			$response->setStatusCode(406, 'exist other client with the same numer document' );
	    			return $response;
		        }

		        $checkEmail = $em->getRepository(Clients::class)->findBy(['email' => $dataClient['email'] ],['id' => 'DESC']);
		        
		        if(count($checkEmail) > 0){
					// case exist other client with the same numer document
	    			$response->setContent( $this->SoapService->setMessageCustom(406,'Error ya existe un cliente registrado con el mismo email') );
	    			
	    			// 406 - Not Acceptable
	    			$response->setStatusCode(406, 'exist other client with the same email' );
	    			return $response;
		        }
    		
    			$newClient 		= new Clients();
    			$walletClient 	= new Wallets();
    		
    			$newClient->setFirstName( $dataClient['name'] );
    			$newClient->setLastName	( $dataClient['lastname'] );
    			$newClient->setEmail	( $dataClient['email'] );
    			$newClient->setDocument	( $dataClient['document'] );
    			$newClient->setTdoc		( $dataClient['tdoc'] );
    			$newClient->setCellphone( $dataClient['cellphone'] );

    			$walletClient->setClient($newClient);
    			$walletClient->setBalance(0.00);
    			// save data & refresh bd
    			$em->persist($newClient);
    			$em->persist($walletClient);
            	$em->flush();
    		
    			// Here we gets the repositories ti's in other away
    			// $responseRepo = $em->getRepository(Clients::class)->addClient( $dataClient );
    			
	    		// 200 - Success
    			$response->setContent( $this->SoapService->setMessageCustom(200,'Excelente su Registro fue procesado Satisfactoriamente' ,'false') );
	    			
	    		$response->setStatusCode(200, 'register client success');
	    		
	    	}else{
				// case fomat invalid or break or format is not client
    			$response->setContent( $this->SoapService->messageXmlInvalid() );
    			$response->setStatusCode(400, 'fomat invalid or break or is not a client format' );
    		}    		

    	}else{
    		// case apikey invalid
    		$response->setContent( $this->SoapService->messageApikeyInvalid() );
    		$response->setStatusCode(500, 'invalid apikey' );
    	}	
        
        return $response;    
    }

    /**
     * @Route("/v1/login", methods={"POST"}, name="login_soap")
   	 */
    public function loginSoap(Request $request)
    {
    	$response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');
        $contentBody = $request->getContent();
		
		if($request->headers->get('apikey') && $this->apikey == $request->headers->get('apikey') )
    	{
			// New obj DOM
			$dom = new \DOMDocument;
			$xml = @$dom->loadXML($contentBody);
			
			if($xml && $this->SoapService->clientLoginIsValid($contentBody) )
    		{
    			$em = $this->getDoctrine()->getManager();
    			$dataLoginClient = $this->SoapService->getDataLogin($contentBody);
    			$responseRepo = $em->getRepository(Clients::class)->findClient($dataLoginClient);
				
    			if(count($responseRepo) > 0){
    				// Success
					$response->setContent( $this->SoapService->setMessageCustom(200,'Auth Success','false') );

    			}else{
    				// No Found 404 - no exist
    				$response->setStatusCode(404, 'Datos Invalidos' );
    				$response->setContent( $this->SoapService->setMessageCustom(404,'Datos Invalidos') );
    			}

    		}else{
    			// case fomat invalid or break or format is not client
    			$response->setContent( $this->SoapService->messageXmlInvalid() );
    			$response->setStatusCode(400, 'fomat invalid or break or is not a client format' );
    		}
		}else{
			// case apikey invalid
    		$response->setContent( $this->SoapService->messageApikeyInvalid() );
    		$response->setStatusCode(500, 'invalid apikey' );
		}

		return $response;
    }
}