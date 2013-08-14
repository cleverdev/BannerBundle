<?php

namespace cleverdev\BannerBundle\Model;

/**
 * Class BannerInterface
 * @package cleverdev\BannerBundle\Model
 */
interface BannerInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @return mixed
     */
    public function getSpot();

    /**
     * @return mixed
     */
    public function getBanner();

    /**
     * @return mixed
     */
    public function getLink();

    /**
     * @return mixed
     */
    public function getEnabled();

    /**
     * @param $clickCount
     *
     * @return mixed
     */
    public function setClickCount($clickCount);

    /**
     * @return mixed
     */
    public function getClickCount();
}