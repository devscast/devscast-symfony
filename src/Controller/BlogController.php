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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 * @Route("/blog", schemes={"HTTP","HTTPS"})
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class BlogController extends  AbstractController
{

    /**
     * @Route(path="", name="blog_index", methods={"GET"})
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index() {

    }

    public function show(){

    }
}
