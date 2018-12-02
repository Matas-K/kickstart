<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @param UserInterface|null $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(UserInterface $user = null)
    {
        if (!$user) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        return $this->render('admin/index.html.twig');
    }
    
    /**
     * @Route("/review", name="review")
     * @param UserInterface|null $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function review(UserInterface $user = null)
    {
        if (!$user) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        if (in_array('ROLE_MENTORIUS', $user->getRoles())) {
            return $this->render('admin/review.html.twig');
        }
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->render('admin/plan.html.twig');
        }
        // Design system to not reach this line: produce HTTP 500 response
        throw new AccessDeniedException('User not authorised by known roles');
    }
}
