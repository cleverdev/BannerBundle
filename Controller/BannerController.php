<?php

namespace cleverdev\BannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BannerController extends Controller
{
    /**
     * Redirect to banner link
     *
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function goAction($id)
    {
        $banner_service = $this->get('banner_service');

        $link = $banner_service->getLink($id);

        return $this->redirect($link);
    }
}
