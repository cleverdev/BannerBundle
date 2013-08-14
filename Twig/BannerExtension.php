<?php

namespace cleverdev\BannerBundle\Twig;

use cleverdev\BannerBundle\Services\Banner;

/**
 * Class BannerExtension
 * @package cleverdev\BannerBundle
 */
class BannerExtension extends \Twig_Extension
{
    /**
     * @var Banner
     */
    protected $banner_service;

    /**
     * @param Banner $banner_service
     */
    public function __construct(Banner $banner_service)
    {
        $this->banner_service = $banner_service;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'render_banner' => new \Twig_Function_Method($this, 'getRenderBanner', array('is_safe' => array('html')))
        );
    }

    /**
     * @param $spot
     *
     * @return string
     */
    public function getRenderBanner($spot)
    {
        return $this->banner_service->getBanner($spot);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'banner_extension';
    }
}