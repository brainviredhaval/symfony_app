<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAll();

        return $this->render('article/list.html.twig',array(
            'articles' => $articles
        ));
    }

    public function createAction()
    {
        $article = new Article();
        $form = $this->createForm(new ArticleType(), $article);

        return $this->render('article/create.html.twig',array(
            'form' => $form->createView()
        ));
    }

    public function storeAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(new ArticleType(), $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $article->setCreatedAt(new \DateTime('now'));
            $article->setUpdatedAt();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article_home');
        }
        return $this->render('article/create.html.twig',array(
            'form' => $form->createView()
        ));
    }
}