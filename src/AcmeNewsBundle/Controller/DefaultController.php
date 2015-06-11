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
     * @Route("/news")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return ['pagination' => $this->getPaginatedNews($request->query->getInt('page', 1))];
    }

    /**
     * @Route("/news.xml", defaults={"_format" = "xml"})
     * @Template()
     */
    public function indexXmlAction(Request $request)
    {
        return ['pagination' => $this->getPaginatedNews($request->query->getInt('page', 1))];
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
     * @Route("/more-news/{id}")
     * @Template()
     */
    public function blockAction($id)
    {
        $newsRepository = $this->get('acme_news.repository.news');
        return ['news' => $newsRepository->findMoreById($id, 3)];
    }

    /**
     * @param $page
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    private function getPaginatedNews($page)
    {
        $newsRepository = $this->get('acme_news.repository.news');
        $paginator = $this->get('knp_paginator');

        return $paginator->paginate(
            $newsRepository->findByPublished(true),
            $page // page number
        );
    }
}
