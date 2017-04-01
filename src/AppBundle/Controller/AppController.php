<?php

namespace AppBundle\Controller;

use AppBundle\Repository\HistoryRepository;
use AppBundle\Repository\UrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Url;
use AppBundle\Entity\History;
use AppBundle\Form\UrlType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



/**
 *
 * Class AppController
 * @package AppBundle\Controller
 */
class AppController extends Controller
{
    /**
     * @Route("/", name="app_app.index")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $url = new Url();
        $form = $this->createForm(UrlType::class, $url);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $hash = '';
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Url $url */
            $url = $form->getData();
            $hash = $this->get('app.hash_generate')->generateHash(6);
            $url->setShortUrl($hash);
            $url->setClicks(0);
            $url->setCreatedAt(new \DateTime());
            $em->persist($url);
            $em->flush();
            unset($url);
            unset($form);
            $url = new Url();
            $form = $this->createForm(UrlType::class, $url);
        }

        $dql   = "SELECT a FROM AppBundle:Url a";
        $query = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('AppBundle:app:index.html.twig', array(
            'form' => $form->createView(),
            'pagination'=>$pagination,
            'hash'=>$hash
        ));
    }

    /**
     * @Route("/history/{hash}", name="app_app.history")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function historyAction(Request $request, $hash){
        $repository = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Url');
        /** @var HistoryRepository $historyRepository */
        $historyRepository = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:History');
        /** @var Url $url */
        $url = $repository->findOneBy(array(
            'shortUrl'=>$hash
        ));
        $history = $url->getHistories();
        $clicksStat = $historyRepository->getStatByDate($history);
        $agentStat = $historyRepository->getStatByAgent($history);
        $referrersStat = $historyRepository->getStatByReferrers($history);
        $ipStat = $historyRepository->getStatByIp($history);

        return $this->render('AppBundle:app:history.html.twig', array(
            'history'=>$history,
            'clickStat'=>$clicksStat,
            'agentStat'=>$agentStat,
            'referrersStat'=>$referrersStat,
            'ipsStat'=>$ipStat,
            'url'=>$url
        ));
    }


    /**
     * @Route("/{hash}", name="app_app.to_real")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toRealAction(Request $request, $hash){
        if(preg_match('/[\'\"<>@;.]+/', $hash)){
            throw new NotFoundHttpException('Page not found');
        }

        $em = $this->getDoctrine()->getManager();
        /** @var UrlRepository $urlRepository */
        $urlRepository = $em->getRepository('AppBundle:Url');
        $url = $urlRepository->getRealUrl($hash);
        if(is_null($url)){
            throw new NotFoundHttpException('Page not found');
        }
        /** @var Url $u */
        $u = $urlRepository->findOneBy(array(
            'shortUrl'=>$hash
        ));
        $history = new History();
        $agent = $request->headers->get('User-Agent');
        $referrer = $request->headers->get('referer');
        $history->setUrl($u);
        $history->setCreatedAt(new \DateTime());
        $history->setIp($request->getClientIp());
        $history->setReferrers(is_null($referrer)?'':$referrer);
        $history->setBrowsers($agent);
        $u->addHistory($history);
        $em->persist($u);
        $em->flush();
        $urlRepository->incrClicks($hash);
        return $this->redirect($url);

    }
}
