<?php

namespace Clarity\YandexOAuthBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OAuthController extends Controller
{
    public function getTokenAction(Request $request)
    {
        $appName = $request->query->get('state');
        $code = $request->query->get('code');

        $token = $this
            ->get('clarity_yandex.oauth.manager')
            ->getToken($appName, $code);
    }
}
