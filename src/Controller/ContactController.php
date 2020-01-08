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

use App\Data\ContactData;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController
 * @Route("/contact", schemes={"HTTP", "HTTPS"})
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ContactController extends AbstractController
{

    /**
     * @Route("", name="contact", methods={"GET", "POST"})
     * @param Request $request
     * @param ContactNotification $contactNotification
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(Request $request, ContactNotification $contactNotification)
    {
        $contact = new ContactData();
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $this->addFlash('success', 'Nous avons réçu votre mail :)');
            $contactNotification->notify($contact);
            return $this->redirectToRoute('home');
        }

        return $this->render("app/statics/contact.html.twig", [
            'contactForm' => $contactForm->createView()
        ]);
    }
}
