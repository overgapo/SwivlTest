<?php

namespace AcmeNewsBundle\Controller;

use AcmeNewsBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/news.{_format}", defaults={"_format": "html"}, requirements={"_format": "html|xml"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $newsRepository = $this->get('acme_news.repository.news');
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $newsRepository->findByPublished(true),
            $request->query->getInt('page', 1) // page number
        );

        return ['pagination' => $pagination];
    }

    /**
     * @Route("/news/{id}")
     * @Template()
     * @ParamConverter("news", class="AcmeNewsBundle:News", options={
     *  "repository_method" = "findPublishedById",
     *  "mapping" = {"id" = "id"},
     *  "map_method_signature" = true
     * })
     */
    public function showAction(News $news)
    {
        return ['news' => $news];
    }

    /**
     * Renders block with news propositions
     *
     * @Route("/more-news/{id}")
     * @Template()
     */
    public function blockAction($id)
    {
        $newsRepository = $this->get('acme_news.repository.news');
        return ['news' => $newsRepository->findMoreById($id, 3)];
    }
}
