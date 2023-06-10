<?php

namespace App\Controller;

use App\Controller\Service\CartService;
use App\Entity\Order;
use App\Entity\RecapDetails;
use Symfony\Component\HttpFoundation\Request;
use App\Form\OrderType;
use App\Form\Transporter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class OrderController extends AbstractController
{
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/order/create', name: 'order_index')]
    public function index(CartService $cartService): Response
    {


        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'recapCart' => $cartService->getTotal()

            ]);
    }
    #[Route('/order/verify', name: 'order_prepare')]
    public function prepareOrder(CartService $cartService, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute(route:'app_login');
        }
        $form = $this->createForm(OrderType::class, null, [
        'user' => $this->getUser()
         ]);

         $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $datetime = new \DateTime(datetime:'now');
            $tranporter = $form->get('transporter')->getData();
            $delivery = $form->get('addresses')->getData();
            $deliveryForOrder = $delivery->getFirstName() . ' ' . $delivery->getLastName();
            $deliveryForOrder .= '</br>' . $delivery->getPhone();
            if ($delivery->getCompany()) {
                $deliveryForOrder .= ' - ' . $delivery->getCompany();
            }
            $deliveryForOrder .= '</br>' . $delivery->getAddress();
            $deliveryForOrder .= '</br>' . $delivery->getPostalCode();
            $deliveryForOrder .= '</br>' . $delivery->getCountry();
            $order = new Order();
            $reference = $datetime->format(format:'dmy') . '-' . uniqid();
            $order->setUser($this->getUser());
            $order->setReference($reference);
            $order->setCreatedAt($datetime);
            $order->setDelivery($deliveryForOrder);
            $order->setTransporterName($tranporter->getTitle());
            $order->setTransporterPrice($tranporter->getPrice());
            $order->setIsPaid(isPaid: 0);
            $order->setMethod(method:'string');

            $this->em->persist($order);

            foreach ($cartService->getTotal() as $product) {
                $recapDetails = new RecapDetails();
                $recapDetails->setOrderProduct($order);
                $recapDetails->setQuantity($product['quantity']);
                $recapDetails->setPrice($product['product']->getPrice());
                $recapDetails->setProduct($product['product']->getTitle());
                $recapDetails->setTotalRecap(
                    totalRecap:$product['product']->getPrice() + $product['quantity']
                );
                $this->em->persist($recapDetails);
            }
            $this->em->flush();
            return $this->render('order/recap.html.twig', [

                'method' => $order->getMethod(),
                'recapCart' => $cartService->getTotal(),
                'transporter' => $tranporter,
                'delivery' => $deliveryForOrder,
                'reference' => $order->getReference()
            ]);
        }
        return $this->redirectToRoute(route:'order_prepare');
    }
}
