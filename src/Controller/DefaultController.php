<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Services\SoapService;
use ApiPlatform\Core\Annotation\ApiResource;


use App\Entity\Clients;
class DefaultController extends AbstractController {

    private $apikey = null;
    public function __construct()
    {

    }
    /**
     * @Route("/", methods={"GET","POST"})
     */
	public function index(Request $request)
    {
    	//   $headers = $request->headers->all();
    	// HEADERS -> $request->headers->get('content-type');
    	// body -> $request->getContent()

        $response = new Response();
		$SoapService = new SoapService();

        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
        $response->setContent( $SoapService->body() );
        
        return $response;
    }

}