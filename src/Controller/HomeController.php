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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class HomeController
 * @Route(schemes={"HTTP", "HTTPS"})
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index()
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $services = json_decode(file_get_contents($projectDir . "/resources/services.json"));
        $team = json_decode(file_get_contents($projectDir . "/resources/team.json"));
        return $this->render('index.html.twig', compact("services", "team"));
    }

    /**
     * @Route("/about", name="about", methods={"GET"})
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function about()
    {
        return $this->render("app/statics/about.html.twig");
    }

    /**
     * @Route("/privacy", name="privacy", methods={"GET"})
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function privacy()
    {
        return $this->render("app/statics/policy.html.twig");
    }

    /**
     * @Route("/contact", name="contact", methods={"GET", "POST"})
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function contact()
    {
        return $this->render("app/statics/contact.html.twig");
    }
}
