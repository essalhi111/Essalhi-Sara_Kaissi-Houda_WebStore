<?php

namespace App\Controller\Admin;

use App\Entity\CategoryShop;
use App\Entity\Product;
use App\Entity\Transporter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CategoryShopCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('WebStore');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Category', 'fa-solid fa-shop', CategoryShop::class);
        yield MenuItem::linkToCrud('Produit', 'fa-solid fa-basket-shopping', Product::class);
        yield MenuItem::linkToCrud(label:'Transporteur', icon:'fa-solid fa-bus-simple', entityFqcn:Transporter::class);
    }
}
