<?php

namespace cleverdev\BannerBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class Banner
 * @package cleverdev\BannerBundle\Services
 */
class Banner
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    protected $templating;

    /**
     * @var
     */
    protected $options;

    /**
     * @param EntityManager $em
     * @param EngineInterface $templating
     * @param $options
     */
    public function __construct(EntityManager $em, EngineInterface $templating, $options)
    {
        $this->em = $em;
        $this->templating = $templating;
        $this->options = $options;
    }

    /**
     * Render need banner(s)
     *
     * @param $spot
     * @return string
     */
    public function getBanner($spot)
    {
        $params = $this->options['spots'][$spot]['params'];
        $repository = $this->em->getRepository($this->options['banner_class']);

        $orderDerection = empty($params['order_derection']) ? 'ASC' : $params['order_derection'];
        $orderBy = empty($params['order_by']) ? array() : array($params['order_by'] => $orderDerection);
        $limit = empty($params['max_count']) ? null : $params['max_count'];

        $banners = $repository->findBy(array(
                'spot' => $spot,
                'enabled' => true
            ), $orderBy, $limit);

        return $this->templating->render($this->options['spots'][$spot]['template'],
                array(
                    'banners' => $banners,
                    'params' => $params
                ));
    }

    /**
     * Return banner link and increment click_count
     *
     * @param $id
     *
     * @return mixed
     */
    public function getLink($id)
    {
        $repository = $this->em->getRepository($this->options['banner_class']);
        $banner = $repository->find($id);

        $banner->setClickCount($banner->getClickCount() + 1);
        $this->em->persist($banner);
        $this->em->flush();

        return $banner->getLink();
    }
}