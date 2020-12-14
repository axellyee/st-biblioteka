<?php

namespace App\Controller\Admin\Users;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserViewController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/admin/user/list", name="admin_user_list")
     */
    public function __invoke(): Response
    {
        $users = $this->userRepository->findBy([]);

        return $this->render('admin/users/list.html.twig', [
            'users' => $users,
        ]);
    }
}
