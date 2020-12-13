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

use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectController
 * @Route("/projects", name="app_project_")
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ProjectController extends AbstractController
{
    private stdClass $projects;

    /**
     * @return mixed
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function getProjects()
    {
        $projectDir = $this->getParameter("kernel.project_dir");
        if (is_null($this->projects)) {
            $this->projects = json_decode(file_get_contents($projectDir . "/resources/projects.json"));
        }
        return $this->projects;
    }

    /**
     * @Route(path="", name="index", methods={"GET"})
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(): Response
    {
        return $this->render("@frontend/projects/index.html.twig", [
            'projects' => $this->getProjects()
        ]);
    }

    /**
     * @Route(
     *     path="/{name}",
     *     name="show",
     *     methods={"GET"},
     *     requirements={"name":"[\w]+"}
     * )
     * @param string $name
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function show(string $name): Response
    {
        $projects = $this->getProjects()->data;
        $project = array_reduce($projects, function ($acc, $project) use ($name) {
            if (mb_strtolower($project->name) == strtolower($name)) {
                $acc = $project;
            }
            return $acc;
        }, null);

        if ($project) {
            return $this->render("@frontend/projects/show.html.twig", compact("project"));
        }

        throw new NotFoundHttpException();
    }
}
