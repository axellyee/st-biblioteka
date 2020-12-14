<?php

namespace App\Controller\Admin\Users;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserDeleteController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/user/{user}/delete", name="admin_user_delete")
     */
    public function __invoke(User $user): Response
    {
        $this->manager->remove($user);
        $this->manager->flush();

        $this->addFlash('success', 'Lietotājs izdzēsts!');

        return $this->redirectToRoute('admin_user_list');
    }
}
