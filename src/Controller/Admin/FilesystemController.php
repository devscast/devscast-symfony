<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use SplFileInfo;
use DirectoryIterator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class FilesystemController
 * @Route("/admin/filesystem", schemes={"HTTP", "HTTPS"})
 * @package App\Controller\Admin
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class FilesystemController extends AbstractController
{

    /** @var string */
    private $root;

    /** @var string */
    private $webRoot;

    /**
     * FilesystemController constructor.
     */
    public function __construct()
    {
        $this->root = $this->getParameter('kernel.project_dir');
        $this->webRoot = $this->root . '/public';
    }

    /**
     * @Route(path="", name="admin_files_index", methods={"GET"})
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index()
    {
        try {
            $files = new DirectoryIterator($this->root . '/public/images');
        } finally {
            return $this->render("admin/files/index.html.twig", [
                'files' => $files ?? null
            ]);
        }
    }

    /**
     * @Route(path="/show", name="admin_files_show", methods={"GET"})
     * @param Request $request
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function show(Request $request)
    {
        try {
            $filename = $request->query->get('file');
            $directory = is_dir($filename) ? new DirectoryIterator($filename) : null;
            $file = is_file($filename) ? new SplFileInfo($filename) : null;
        } finally {
            return $this->render("admin/files/index.html.twig", [
                'files' => $directory ?? null,
                'file' => $file ?? null,
                'preview' => $this->getPreview($file)
            ]);
        }
    }

    /**
     * @Route(path="/delete", name="admin_files_delete", methods={"DELETE"})
     * @param Request $request
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function delete(Request $request)
    {
        $key = $request->request->get('_key');
        if ($this->isCsrfTokenValid('delete' . $key, $request->request->get('_token'))) {
            $filename = $request->request->get('_file');
            if (is_file($filename)) {
                unlink($filename);
            }
        }

        return $this->redirectToRoute('admin_files_index');
    }

    /**
     * @param SplFileInfo|null $file
     * @return string|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function getPreview(?SplFileInfo $file): ?string
    {
        if ($file && in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png'])) {
            return str_ireplace($this->webRoot, '', $file->getRealPath());
        }
        return null;
    }
}

