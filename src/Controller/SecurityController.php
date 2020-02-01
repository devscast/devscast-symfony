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

use App\Data\ResetPasswordData;
use App\Form\Security\ResetPasswordType;
use Exception;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class SecurityController
 * @Route("/auth", schemes={"HTTP", "HTTPS"})
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
     * @throws Exception (datetime)
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        Security $security
    ): Response
    {
        if (is_null($security->getUser())) {
            $user = new User();
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user
                    ->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()))
                    ->setRoles(['ROLE_USER']);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                // do anything else you need here, like send an email

                return $this->redirectToRoute('home');
            }

            return $this->render('security/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute('home');
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
        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('security/login.html.twig', [
            'username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route(path="/reset", name="reset", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function reset(Request $request): Response
    {
        $data = new ResetPasswordData();
        $resetForm = $this->createForm(ResetPasswordType::class, $data);
        $resetForm->handleRequest($request);

        if ($resetForm->isSubmitted() && $resetForm->isValid()) {
            // Todo: Send Reset Email With Token
            return $this->redirectToRoute('login');
        }

        return $this->render('security/reset.html.twig', [
            'resetForm' => $resetForm->createView()
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
