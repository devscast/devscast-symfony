<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @Route("/auth")
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class SecurityController extends AbstractController
{

    /**
     * @Route("/register", name="register", methods={"GET", "POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Security $security
     * @return Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        Security $security
    ): Response {
        if ($security->getUser()) {
            return $this->redirectToRoute('home');
        }

        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user
                ->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()))
                ->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/login", name="login", methods={"GET","POST"})
     * @param Security $security
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function login(Security $security, AuthenticationUtils $authenticationUtils): Response
    {
        if ($security->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('security/login.html.twig', [
            'username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route(path="/logout", name="logout", methods={"GET"})
     * @throws Exception
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function logout(): void
    {
        throw new Exception('This should never be reached!');
    }
}
