<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class SecurityController extends AbstractController
{

    /**
     * @Route(path="/login", name="login", methods={"GET","POST"})
     * @param Security $security
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function login(Security $security, AuthenticationUtils $authenticationUtils): Response
    {
        if ($security->isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'Already Logged In !');
            return $this->redirectToRoute('admin.index');
        }

        return $this->render('security/login.html.twig', [
           'username' => $authenticationUtils->getLastUsername(),
           'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route(path="/logout", name="logout", methods={"GET"})
     * @throws \Exception
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
