<?php

namespace Clarity\YandexOAuthBundle\Controller;

use Clarity\YandexOAuthBundle\Exception\GetAuthorizationCodeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OAuthController extends Controller
{
    protected $uriGlue = '--';

    /**
     * Send request to Yandex ouath get authorization code for app
     * User was redirected to Yandex passport page to login and allow or decline access to app
     *
     * @param Request $request
     * @param string $appName - configured application name from config.yml
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws GetAuthorizationCodeException
     */
    public function requestTokenAction(Request $request, $appName)
    {
        $deviceId = $request->query->get('device_id');
        $deviceName = $request->query->get('device_name');
        $stateChunks = array($appName);

        if ($deviceId) {
            $stateChunks[] = $deviceId;

            if ($deviceName) {
                $stateChunks[] = $deviceName;
            }
        }

        /** @var \Clarity\YandexOAuthBundle\Model\Response\CodeResponse $codeResponse */
        $codeResponse = $this
            ->getYandexOauthService()
            ->getAuthorizationCode(
                $appName, 
                implode($this->uriGlue, $stateChunks),
                $deviceId,
                $deviceName
            );

        return $this->redirect($codeResponse->getLocation());
    }

    /**
     * Return user after allowing or decline access to this action
     * Exchange received in url code to access token if user allow access to app
     * Throw an exception with error message if user decline access to app
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws GetAuthorizationCodeException
     */
    public function exchangeCodeToTokenAction(Request $request)
    {
        // Process error returned in redirect url parameters
        if ($request->query->has('error')) {
            throw new GetAuthorizationCodeException(
                $request->query->get('error') . ' : ' . $request->query->get('error_description')
            );
        }

        $parameters = explode($this->uriGlue, $request->query->get('state'));
        $code = $request->query->get('code');

        $this
            ->getYandexOauthService()
            ->exchangeCodeToToken(
                $code,
                $parameters[0],
                array_key_exists(1, $parameters) ? $parameters[1] : null,
                array_key_exists(2, $parameters) ? $parameters[2] : null
            );

        return $this->redirectToRoute($this->getAppRedirectRoute($parameters[0]));
    }

    /**
     * @return \Clarity\YandexOAuthBundle\Service\YandexOAuthService
     */
    protected function getYandexOauthService()
    {
        return $this->get('clarity_yandex.oauth.service');
    }

    /**
     * @param $appName
     * @return string
     */
    protected function getAppRedirectRoute($appName)
    {
        $apps = $this->getParameter('clarity_yandex_oauth.apps');

        return array_key_exists('redirect_route', $apps[$appName])
            ? $apps[$appName]['redirect_route']
            : $this->getParameter('clarity_yandex_oauth.default_redirect_route');
    }
}
