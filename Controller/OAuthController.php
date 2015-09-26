<?php

namespace Clarity\YandexOAuthBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OAuthController extends Controller
{
    public function generateTokenAction(Request $request, $appName, $scope)
    {
        $deviceId = $request->query->get('device_id');
        $deviceName = $request->query->get('device_name');

        $codeResponse = $this
            ->get('clarity_yandex.oauth.service')
            ->getAuthorizationCode($appName, $appName, $deviceId, $deviceName);

        if ($codeResponse->hasError()) {
            die(var_dump($codeResponse->getError()));
        }

        return $this->redirect($codeResponse->getLocation());
    }

    public function getTokenAction(Request $request)
    {
        $appName = $request->query->get('state');
        $code = $request->query->get('code');

        $token = $this
            ->get('clarity_yandex.oauth.service')
            ->exchangeCodeToToken($code, $appName);
    }
}
