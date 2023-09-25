<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to('contact@diancirediallo.fr')
            ->subject($contact->getSubject())
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact 
            ]);

            $mailer->send($email);

            $this->addFlash('success', "Votre message a été envoyé avec succès ! Nous vous répondrons dès que possible !");
            return $this->redirectToRoute('app_app');
        }

        
        $categories = $categoryRepository->findAll();
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'categories' => $categories,
            'form' => $form,
        ]);
    }
}
