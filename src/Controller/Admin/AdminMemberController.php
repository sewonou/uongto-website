<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use App\Repository\MemberRepository;
use App\Form\MemberType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMemberController extends AbstractController
{
    private $memberRepo;

    public function __construct(MemberRepository $memberRepo)
    {
        $this->memberRepo = $memberRepo;
    }

    #[Route('/admin/member', name: 'app_admin_member')]
    public function index(): Response
    {
        return $this->render('admin/member/index.html.twig', [
            'members' => $this->memberRepo->findAll(),
        ]);
    }

    #[Route('/admin/member/new', name: 'app_admin_member_add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $member->setAuthor($this->getUser());
            $manager->persist($member);
            $manager->flush();
            $this->addFlash('success',"le membre <strong>{$member->getName()}</strong>  a bien été enregister");
            return $this->redirectToRoute('app_admin_member');
        }
        return $this->render('admin/member/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/member/{id}', name: 'app_admin_member_edit')]
    public function modify(Request $request, EntityManagerInterface $manager, Member $member): Response
    {

        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        if($form->isSubmitted && $form->isValid()){
            $member->setAuthor($this->getUser());
            $manager->persist($member);
            $manager->flush();
            $this->addFlash('success',"le membre <strong>{$member->getName()}</strong>  a bien été enregister");
            return $this->redirectToRoute('app_admin_member');
        }
        return $this->render('admin/member/new.html.twig', [
            'form' => $form->createView(),
            'member' => $member
        ]);
    }


}
