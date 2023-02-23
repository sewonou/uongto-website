<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    #[Route('/admin/user', name: 'app_admin_user')]
    public function index(): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $this->userRepo->findAll(),
        ]);
    }

    #[Route('/admin/user/new', name: 'app_admin_user_add')]
    public function add(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

           if($form->isSubmitted() && $form->isValid()){

                $password = $user->getPassword();
                $password = $encoder->hashPassword($user, $password);
                $user->setPassword($password);
                $this->addFlash('success', "L'utilisateur <strong>{$user->getFullName() }</strong> a bien été enregister");
                $manager->persist($user);
                $manager->flush();
                return $this->redirectToRoute('app_admin_user');
            }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }


}
