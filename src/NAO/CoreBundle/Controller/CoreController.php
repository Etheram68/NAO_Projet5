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
            'listArticles' => $listArticles,
            'observations'   => $this->container->get('app.obs')->getLastObersations(4)
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
                ->setTo('nao.support@projet5-site.fr')
                ->setBody($this->renderView('emails/contactMail.html.twig', array(
                    'firstName' => $name,
                    'lastName' => $lastName,
                    'mailAdress' => $mail,
                    'town' => $town,
                    'content' => $content,
                )));
            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('notice', 'Votre E-mail à bien été envoyée, nous vous répondrons dans les plus brefs délais');

            return $this->redirectToRoute('homepage');
        }
        return $this->render('core/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Mention Légale
     * @Route("/Mention", name="mention")
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mentionAction()
    {
        return $this->render('ressource\mentionlegale.html.twig');
    }

    /**
     * CGU
     * @Route("/cgu", name="cgu")
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cguAction()
    {
        return $this->render('ressource\cgu.html.twig');
    }

    /**
     * about
     * @Route("/about", name="about")
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutAction()
    {
        return $this->render('about\about.html.twig');
    }

}
