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
        $news = $this->getDoctrine()
            ->getRepository('AcmeNewsBundle:News')
            ->findByPublished(true)
        ;
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news,
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return ['pagination' => $pagination];
    }

    /**
     * @Route("/news.xml", defaults={"_format" = "xml"})
     * @Template()
     */
    public function indexXmlAction(Request $request)
    {
        $news = $this->getDoctrine()
            ->getRepository('AcmeNewsBundle:News')
            ->findByPublished(true)
        ;
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news,
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
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
}
