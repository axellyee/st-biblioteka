<?php

namespace App\Controller\Admin\Users;

use App\Entity\User;
use App\Form\Admin\User\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCreateController extends AbstractController
{
    private $manager;
    private $encoder;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/admin/user/create", name="admin_user_create")
     */
    public function __invoke(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null != $user->getPlainPassword()) {
                $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }

            $this->manager->persist($user);
            $this->manager->flush();

            $this->addFlash('success', 'Lietotājs tika izveidots!');

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/users/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
