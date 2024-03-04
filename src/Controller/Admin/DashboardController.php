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
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

use App\Repository\UserRepository; 


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        return $this->render('admin/index.html.twig');
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

        yield MenuItem::section('Guias');
        yield MenuItem::linkToRoute('Valoracion', 'fa fa-calendar', 'app_grafico_guias');
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

    #[Route('/modificarRuta', name: 'modificarRuta')]
    public function editarRuta(EntityManagerInterface $entityManager,UserRepository $userRepository): Response
    {
        return $this->render('modificar_ruta/index.html.twig', [
            'localidades' => $entityManager->getRepository(Localidad::class)->findAll(),
            'guias' => $entityManager->getRepository(User::class)->findByRoles(['ROLE_GUIDE'])
        ]);
    }
}
