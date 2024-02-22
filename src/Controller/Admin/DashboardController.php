<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use App\Entity\User;
use App\Entity\Tour;
use App\Entity\Ruta;
use App\Entity\Visita;
use App\Entity\Provincia;
use App\Entity\Localidad;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        return $this->render('admin/index.html.twig');
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard eredirect to different pages depending on the usr
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        //return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('FreeTour');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Home', 'fa fa-home');

        yield MenuItem::section('Usuarios');
        yield MenuItem::linkToCrud('User', 'fas fa-solid fa-user', User::class);
        
        yield MenuItem::section('Rutas/Tour');
        yield MenuItem::linkToCrud('Tour', 'fas fa-solid fa-compass', Tour::class);
        yield MenuItem::linkToCrud('Ruta', 'fas fa-solid fa-code-merge', Ruta::class);
        yield MenuItem::linkToCrud('Visitas', 'fas fa-solid fa-camera-retro', Visita::class);

        yield MenuItem::section('Ubicaciones');
        yield MenuItem::linkToCrud('Localidad', 'fas fa-solid fa-map-pin', Localidad::class);
        yield MenuItem::linkToCrud('Provincia', 'fas fa-regular fa-map', Provincia::class);


        yield MenuItem::section('Calendario Tours');
        yield MenuItem::linkToRoute('Calendario', 'fa fa-calendar', 'tourCalendar');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setAvatarUrl('fotos_perfil/'.$user->getFoto());    
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureAssets(): Assets{
        return Assets::new()
            ->addCssFile('css/easyAdmin.css');
    }
}
