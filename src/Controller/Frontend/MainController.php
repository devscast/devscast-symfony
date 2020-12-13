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

namespace App\Controller\Frontend;

use App\Data\ContactRequestData;
use App\Form\ContactForm;
use App\Notification\ContactNotification;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PageController
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class MainController extends AbstractController
{
    private BlogRepository $blogRepository;

    /**
     * PageController constructor.
     * @param BlogRepository $blogRepository
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * @Route("/", name="app_home", methods={"GET"})
     */
    public function index(): Response
    {
        $blogs = $this->blogRepository->findBy([], null, 5);
        $projectDir = $this->getParameter('kernel.project_dir');
        $services = json_decode(file_get_contents($projectDir . "/resources/services.json"));
        $team = json_decode(file_get_contents($projectDir . "/resources/team.json"));
        $projects = json_decode(file_get_contents($projectDir . "/resources/projects.json"));
        return $this->render(
            '@frontend/index.html.twig',
            compact("services", "team", "projects", "blogs")
        );
    }

    /**
     * @Route("/contact", name="app_contact", methods={"GET", "POST"})
     * @param Request $request
     * @param ContactNotification $contactNotification
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function contact(Request $request, ContactNotification $contactNotification): Response
    {
        $contact = new ContactRequestData();
        $contactForm = $this->createForm(ContactForm::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $this->addFlash(
                'success',
                'Nous avons bien reçu votre mail, nous tâcherons de vous répondre dans le plus bref délais  😉 😌'
            );
            $contactNotification->notify($contact);
            return $this->redirectToRoute('home');
        }

        return $this->render("@frontend/statics/contact.html.twig", [
            'contactForm' => $contactForm->createView()
        ]);
    }

    /**
     * @Route("/contributing", name="app_contributing", methods={"GET"})
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function contributing(): Response
    {
        return $this->render("@frontend/statics/contributing.html.twig");
    }

    /**
     * @Route("/code-of-conduct", name="app_conduct", methods={"GET"})
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function conduct(): Response
    {
        return $this->render("@frontend/statics/conduct.html.twig");
    }
}
