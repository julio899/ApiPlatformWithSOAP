<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Wallets;
use App\Services\SoapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $apikey = null;
    private $SoapService = null;
    private $session = null;

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
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8'); //ISO-8859-1

        $contentBody = $request->getContent();

        if ($request->headers->get('apikey') && $this->apikey == $request->headers->get('apikey')) {
            // New obj DOM
            $dom = new \DOMDocument();
            $xml = @$dom->loadXML($contentBody);

            if ($xml && $this->SoapService->clientIsValid($contentBody)) {
                $em = $this->getDoctrine()->getManager();
                $dataClient = $this->SoapService->getDataClient($contentBody);

                $checkDocumet = $em->getRepository(Clients::class)->findBy(['document' => $dataClient['document']], ['id' => 'DESC']);

                if (count($checkDocumet) > 0) {
                    // case exist other client with the same numer document
                    $response->setContent($this->SoapService->setMessageCustom(406, 'Error ya existe un cliente registrado con el mismo nro de documento'));

                    // 406 - Not Acceptable
                    $response->setStatusCode(406, 'exist other client with the same numer document');

                    return $response;
                }

                $checkEmail = $em->getRepository(Clients::class)->findBy(['email' => $dataClient['email']], ['id' => 'DESC']);

                if (count($checkEmail) > 0) {
                    // case exist other client with the same numer document
                    $response->setContent($this->SoapService->setMessageCustom(406, 'Error ya existe un cliente registrado con el mismo email'));

                    // 406 - Not Acceptable
                    $response->setStatusCode(406, 'exist other client with the same email');

                    return $response;
                }

                $newClient = new Clients();
                $walletClient = new Wallets();

                $newClient->setFirstName($dataClient['name']);
                $newClient->setLastName($dataClient['lastname']);
                $newClient->setEmail($dataClient['email']);
                $newClient->setDocument($dataClient['document']);
                $newClient->setTdoc($dataClient['tdoc']);
                $newClient->setCellphone($dataClient['cellphone']);

                $walletClient->setClient($newClient);
                $walletClient->setBalance(0.00);
                $walletClient->setDinamicToken(random_int(100000, 999999));

                // save data & refresh bd
                $em->persist($newClient);
                $em->persist($walletClient);
                $em->flush();

                // Here we gets the repositories ti's in other away
                // $responseRepo = $em->getRepository(Clients::class)->addClient( $dataClient );

                // 200 - Success
                $response->setContent($this->SoapService->setMessageCustom(200, 'Excelente su Registro fue procesado Satisfactoriamente', 'false'));

                $response->setStatusCode(200, 'register client success');
            } else {
                // case fomat invalid or break or format is not client
                $response->setContent($this->SoapService->messageXmlInvalid());
                $response->setStatusCode(400, 'fomat invalid or break or is not a client format');
            }
        } else {
            // case apikey invalid
            $response->setContent($this->SoapService->messageApikeyInvalid());
            $response->setStatusCode(500, 'invalid apikey');
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

        if ($request->headers->get('apikey') && $this->apikey == $request->headers->get('apikey')) {
            // New obj DOM
            $dom = new \DOMDocument();
            $xml = @$dom->loadXML($contentBody);

            if ($xml && $this->SoapService->clientLoginIsValid($contentBody)) {
                $em = $this->getDoctrine()->getManager();
                $dataLoginClient = $this->SoapService->getDataLogin($contentBody);
                $responseRepo = $em->getRepository(Clients::class)->findClient($dataLoginClient);

                if (count($responseRepo) > 0) {
                    $repoWallet = $em->getRepository(Wallets::class)->findBy(['client' => $responseRepo[0]->getId('id')]);
                    // update dinamicToken
                    $repoWallet[0]->setDinamicToken(random_int(100000, 999999));

                    $em->persist($repoWallet[0]);
                    $em->flush();

                    // Success
                    $response->setContent($this->SoapService->setMessageCustom(
                    200,
                    'Auth Success',
                    'false',
                    ['account' => $responseRepo[0]->getId(), 'wallet' => $repoWallet[0]->getId()]
                  ));
                } else {
                    // No Found 404 - no exist
                    $response->setStatusCode(404, 'Datos Invalidos');
                    $response->setContent($this->SoapService->setMessageCustom(404, 'Datos Invalidos'));
                }
            } else {
                // case fomat invalid or break or format is not client
                $response->setContent($this->SoapService->messageXmlInvalid());
                $response->setStatusCode(400, 'fomat invalid or break or is not a client format');
            }
        } else {
            // case apikey invalid
            $response->setContent($this->SoapService->messageApikeyInvalid());
            $response->setStatusCode(500, 'invalid apikey');
        }

        return $response;
    }

    /**
     * @Route("/v1/{wallet}/balance", methods={"GET"}, name="balance")
     */
    public function getBalance(Request $request, $wallet)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $em = $this->getDoctrine()->getManager();
        $repoWallet = $em->getRepository(Wallets::class)->findBy(['id' => $wallet]);

        if ($request->headers->get('apikey') && $this->apikey == $request->headers->get('apikey')) {
            if (isset($repoWallet[0])) {
                $response = new JsonResponse(['balance' => $repoWallet[0]->getBalance()]);
            } else {
                $response = new JsonResponse(['error' => 404, 'message' => 'this wallet no exist']);
            }
        } else {
            $response = new JsonResponse(['error' => 500, 'message' => 'apikey is mandatory']);
        }

        return $response;
    }

    /**
     * @Route("/v1/{wallet}/getcode", methods={"POST"}, name="getcode")
     */
    public function getCode(Request $request, $wallet)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $em = $this->getDoctrine()->getManager();
        $repoWallet = $em->getRepository(Wallets::class)->findBy(['id' => $wallet]);

        if ($request->headers->get('apikey') && $this->apikey == $request->headers->get('apikey')) {
            if (isset($repoWallet[0])) {
                $repoWallet[0]->setDinamicToken(random_int(100000, 999999));

                $em->persist($repoWallet[0]);
                $em->flush();

                $response = new JsonResponse(['code' => $repoWallet[0]->getDinamicToken()]);
            } else {
                $response = new JsonResponse(['error' => 404, 'message' => 'this wallet no exist']);
            }
        } else {
            $response = new JsonResponse(['error' => 500, 'message' => 'apikey is mandatory']);
        }

        return $response;
    }

    /**
     * @Route("/v1/{wallet}/tanssaction", methods={"POST"}, name="tanssaction")
     */
    public function processTanssaction(Request $request, $wallet)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $em = $this->getDoctrine()->getManager();
        $repoWallet = $em->getRepository(Wallets::class)->findBy(['id' => $wallet]);
        $data = json_decode($request->getContent(), true);
        if ($request->headers->get('apikey') && $this->apikey == $request->headers->get('apikey') && isset($data['code']) && isset($data['total'])) {
            if (isset($repoWallet[0])) {
                $code = intval($data['code']);
                $total = floatval($data['total']);
                // si es identico es que procesaremos
                if ($repoWallet[0]->getDinamicToken() === $code) {
                    if (floatval($repoWallet[0]->getBalance()) >= $total) {
                        $repoWallet[0]->setDinamicToken(random_int(100000, 999999));
                        $repoWallet[0]->setBalance(floatval($repoWallet[0]->getBalance() - $total));

                        $em->persist($repoWallet[0]);
                        $em->flush();

                        $response = new JsonResponse([
                  'balance' => $repoWallet[0]->getBalance(),
                  'transsaccion' => true,
                ]);
                    } else {
                        $response = new JsonResponse(['error' => 400, 'message' => 'saldo insuficiente']);
                    }
                } else {
                    $response = new JsonResponse(['error' => 404, 'message' => 'codigo invalido']);
                }
            } else {
                $response = new JsonResponse(['error' => 404, 'message' => 'this wallet no exist']);
            }
        } else {
            $response = new JsonResponse(['error' => 500, 'message' => 'code & apikey & total is mandatory']);
        }

        return $response;
    }

    /**
     * @Route("/v1/{wallet}/deposit", methods={"POST"}, name="deposit")
     */
    public function processDeposito(Request $request, $wallet)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $em = $this->getDoctrine()->getManager();
        $repoWallet = $em->getRepository(Wallets::class)->findBy(['id' => $wallet]);
        $data = json_decode($request->getContent(), true);
        if ($request->headers->get('apikey') && $this->apikey == $request->headers->get('apikey') && isset($data['documento']) && isset($data['phone']) && isset($data['total'])) {
            if (isset($repoWallet[0])) {
                $client = $repoWallet[0]->getClient();
                $documento = intval($data['documento']);
                $cellphone = $data['phone'];
                $total = floatval($data['total']);

                // si es igual es que procesaremos
                if ($client->getDocument() == $documento && $client->getCellphone() == $cellphone) {
                    $repoWallet[0]->setDinamicToken(random_int(100000, 999999));
                    $repoWallet[0]->setBalance(floatval($repoWallet[0]->getBalance() + $total));

                    $em->persist($repoWallet[0]);
                    $em->flush();

                    $response = new JsonResponse([
                'balance' => $repoWallet[0]->getBalance(),
                'transsaccion' => true,
              ]);
                } else {
                    $response = new JsonResponse(['error' => 404, 'message' => 'los datos no coinciden']);
                }
            } else {
                $response = new JsonResponse(['error' => 404, 'message' => 'this wallet no exist']);
            }
        } else {
            $response = new JsonResponse(['error' => 500, 'message' => 'phone & documento & apikey & total is mandatory']);
        }

        return $response;
    }
}
