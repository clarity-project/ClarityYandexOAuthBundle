<?php

namespace Clarity\YandexOAuthBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OAuthController extends Controller
{
    protected $uriGlue = '--';
    /**
     * Send request to yuandex ouath to get access rights to app with specified scopes
     * User was redirected to yandex passport page to login and allow access to app
     *
     * @param Request $request
     * @param string $appName - configured application name from config.yml
     * @param string $scope - configured name of scopes set from config.yml
     */
    public function requestTokenAction(Request $request, $appName, $scope)
    {
        $deviceId = $request->query->get('device_id');
        $deviceName = $request->query->get('device_name');

        $codeResponse = $this
            ->get('clarity_yandex.oauth.service')
            ->getAuthorizationCode(
                $appName, 
                $appName . $this->uriGlue . $scope, 
                $deviceId, 
                $deviceName
            );

        if ($codeResponse->hasError()) {
            die(var_dump($codeResponse->getError()));
        }

        return $this->redirect($codeResponse->getLocation());
    }

    /**
     * Return user after allowing or decline access to this action
     * Exhange received in url code to access token if user allow access to app
     * Throw an exception with error message if user decline access to app
     *
     * @param Request $request
     */
    public function exchangeCodeToTokenAction(Request $request)
    {
        $state = $request->query->get('state');
        $parameters = array_combine(array('app_name', 'scope'), explode($this->uriGlue, $state));
        $code = $request->query->get('code');

        $token = $this
            ->get('clarity_yandex.oauth.service')
            ->exchangeCodeToToken($code, $parameters['app_name'], $parameters['scope']);

        return $this->redirect($codeResponse->getLocation());
    }
}
