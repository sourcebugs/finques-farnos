<?php

namespace FinquesFarnos\AppBundle\Controller\Front;

use Doctrine\ORM\EntityManager;
use FinquesFarnos\AppBundle\Entity\ContactMessage;
use FinquesFarnos\AppBundle\Form\Type\ContactType;
use FinquesFarnos\AppBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 *
 * @category Controller
 * @package  FinquesFarnos\AppBundle\Controller
 * @author   David Romaní <david@flux.cat>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="front_homepage")
     */
    public function homepageAction()
    {
        $slides = $this->getDoctrine()->getRepository('AppBundle:ImageSlider')->getHomepageItems();
        $properties = $this->getDoctrine()->getRepository('AppBundle:Property')->getHomepageItems();

        return $this->render('::Front/homepage.html.twig', array(
                'slides' => $slides,
                'properties' => $properties,
            ));
    }

    /**
     * @Route("/properties/", name="front_properties")
     */
    public function propertiesAction()
    {
        return $this->render('::Front/properties.html.twig');
    }

    /**
     * @Route("/about-us/", name="front_about")
     */
    public function aboutAction()
    {
        return $this->render('::Front/about.html.twig');
    }

    /**
     * @Route("/contact/", name="front_contact")
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Contact $contactForm */
            $contactForm = $form->getData();
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            /** @var Contact $contactToBePersisted */
            $contactToBePersisted = $em->getRepository('AppBundle:Contact')->findOneBy(array('email' => $contactForm->getEmail()));
            if ($contactToBePersisted) {
                $contactToBePersisted
                    ->setName($contactForm->getName())
                    ->setPhone($contactForm->getPhone())
                    ->setEnabled(true);
            } else {
                $contactToBePersisted = $contactForm;
            }
            $fc = $request->get('contact');
            /** @var ContactMessage $message */
            $message = new ContactMessage();
            $message->setContact($contactToBePersisted)->setText($fc['message']);
            $contactToBePersisted->addMessage($message);
            $em->persist($contactToBePersisted);
            $em->persist($message);
            $em->flush();
            // Send email
            /** @var \Swift_Message $emailMessage */
            $emailMessage = \Swift_Message::newInstance()
                ->setSubject('Formulari de contacte pàgina web www.finquesfarnos.com')
                ->setFrom('webapp@finquesfarnos.com')
                ->setTo('info@fiquesfarnos.com')
                ->setBody(
                    $this->renderView(
                        '::Front/contact.email.html.twig',
                        array(
                            'form' => $contactForm,
                            'message' => $fc['message']
                        )
                    )
                )
                ->setCharset('UTF-8')
                ->setContentType('text/html')
            ;
            $this->get('mailer')->send($emailMessage);

            return $this->redirect($this->generateUrl('front_contact_thankyou'));
        }

        return $this->render('::Front/contact.html.twig', array(
                'form' => $form->createView(),
            ));
    }

    /**
     * @Route("/contact/thank-you/", name="front_contact_thankyou")
     */
    public function contactThankYouAction()
    {
        return $this->render('::Front/contact_thank_you.html.twig');
    }

    /**
     * @Route("/privacy/", name="front_privacy")
     */
    public function privacyAction()
    {
        return $this->render('::Front/privacy.html.twig');
    }

    /**
     * @Route("/legal/", name="front_legal")
     */
    public function legalAction()
    {
        return $this->render('::Front/legal.html.twig');
    }

    /**
     * @Route("/credits/", name="front_credits")
     */
    public function creditsAction()
    {
        return $this->render('::Front/credits.html.twig');
    }
}
