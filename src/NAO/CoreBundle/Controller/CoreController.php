<?php

namespace NAO\CoreBundle\Controller;

use NAO\CoreBundle\Entity\Contact;
use NAO\CoreBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class CoreBundleController
 *
 * @package NAO\CoreBundle\Controller
 */
class CoreController extends Controller
{
    /**
     * HomePage
     * @Route("/", name="homepage")
     * @Method({"GET"})
     *
     * @param Request $request Http request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $listArticles = $em->getRepository('NAOBlogBundle:Article')->findBy(
            array(),
            array('date' =>'desc'),
            3,
            0
        );
        return $this->render('homepage\index.html.twig', array(
            'listArticles' => $listArticles
        ));
    }

    /** ContactPage
     * @Route("/contact", name="contact")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->get('form.factory')->create(ContactType::class, $contact);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $mail = $form['mailAdress']->getData();
            $name = $form['firstName']->getData();
            $lastName = $form['lastName']->getData();
            $town = $form['town']->getData();
            $content = $form['content']->getData();


            $message = (new \Swift_Message())
                ->setFrom([$mail])
                ->setTo('estebangrabette@gmail.com')
                ->setBody($this->renderView('emails/contactMail.html.twig', array(
                    'firstName' => $name,
                    'lastName' => $lastName,
                    'mailAdress' => $mail,
                    'town' => $town,
                    'content' => $content,
                )));
            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('notice', 'Votre message à bien été envoyé');

            $this->redirectToRoute('homepage');
        }
        return $this->render('core/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
