<?php

namespace cleverdev\BannerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use cleverdev\BannerBundle\Validator\Constraints\File;
use cleverdev\BannerBundle\Model\BannerInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="banner", indexes={
 *      @ORM\Index(name="banner_spot_idx", columns={"spot"})
 * })
 * @ORM\HasLifecycleCallbacks
 */
class Banner extends AttachModel implements BannerInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min="1",
     *      max="255"
     * )
     */
    protected $title;

    /**
     * @ORM\Column(name="spot", type="string", length=255)
     * @Assert\NotBlank
     */
    protected $spot;

    /**
     * @ORM\Column(name="banner", type="string", length=255)
     * @Assert\NotBlank
     * @File(
     *      mimeTypes = {"image/png", "image/gif", "image/jpeg", "application/x-shockwave-flash"}
     * )
     */
    protected $banner;

    /**
     * @ORM\Column(name="link", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Url
     * @Assert\Length(
     *      max="255"
     * )
     */
    protected $link;

    /**
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled = false;

    /**
     * @ORM\Column(name="click_count", type="integer")
     */
    protected $clickCount = 0;

    /**
     * {@inheritDoc}
     */
    protected function getUploadPath()
    {
        return '/banners';
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Banner
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set spot
     *
     * @param string $spot
     * @return Banner
     */
    public function setSpot($spot)
    {
        $this->spot = $spot;

        return $this;
    }

    /**
     * Get spot
     *
     * @return string
     */
    public function getSpot()
    {
        return $this->spot;
    }

    /**
     * Set banner
     *
     * @param string $banner
     * @return Banner
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Banner
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set enabled
     *
     * @param bool $enabled
     * @return Banner
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool) $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set click count
     *
     * @param int $clickCount
     * @return Banner
     */
    public function setClickCount($clickCount)
    {
        $this->clickCount = $clickCount;

        return $this->clickCount;
    }

    /**
     * Get click count
     *
     * @return int
     */
    public function getClickCount()
    {
        return $this->clickCount;
    }

    /**
     * __toString
     */
    public function __toString()
    {
        return $this->title ?: '';
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function uploadBanner()
    {
        if (false !== $banner = parent::uploadFile($this->banner)) {
            $this->banner = $banner;
        }
    }

    /**
     * @ORM\PreRemove
     */
    public function preRemove()
    {
        if (null !== $this->banner) {
            $this->removeFile($this->banner);
        }
    }
}