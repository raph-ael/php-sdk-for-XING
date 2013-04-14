<?php
/**
 * guzzle Xing OAuth client
 *
 * This is a OAuth Client for the Xing API <https://dev.xing.com/>. It is currently in heavy
 * alpha state.
 *
 * It uses Guzzle <http://guzzlephp.org/> as the underlying HTTP/OAuth1 Client.
 *
 * @license MIT or GPLv3
 * @copyright (C) 2013 Björn Schotte <bjoern.schotte@googlemail.com> <bjoern.schotte@mayflower.de>
 */

namespace BjoernSchotte\WebService;

use Guzzle\Common\Collection;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Symfony\Component\HttpFoundation\RedirectResponse;

class XingClient extends Client
{
    public $XingUserId = null;
    public $XingAccessToken = false;
    public $XingAccessTokenSecret = false;

    public static function factory($config = array())
    {
        $defaults = array(
            'base_url' => 'https://api.xing.com/{version}/',
            'version' => 'v1',
        );
        $required = array('base_url', 'version', 'consumer_key', 'consumer_secret'); // , 'token', 'token_secret');
        $config = Collection::fromConfig($config, $defaults, $required);

        $client = new self($config->get('base_url'), $config);

        // Attach a service description to the client
        $description = ServiceDescription::factory(__DIR__ . DIRECTORY_SEPARATOR . 'client.json');
        $client->setDescription($description);

        $client->addSubscriber(new OauthPlugin(array(
            'consumer_key'    => $config['consumer_key'],
            'consumer_secret' => $config['consumer_secret'],
            'token'           => $config['token'],
            'token_secret'    => $config['token_secret'],
        )));

        return $client;
    }

    /**
     * get request token
     *
     * starts the OAuth dance
     *
     * @return bool
     */
    public function XingRequestToken()
    {
        error_log("Callback: " . $this->getConfig()->get('callback'));
        $request = $this->post('request_token?oauth_callback=' . urlencode($this->getConfig()->get('callback')));

        $response = $request->send();

        $oauth_token = $oauth_token_secret = $oauth_callback_confirmed = null;
        parse_str((string)$response->getBody());

        if ($response->getStatusCode() == 201 && $oauth_callback_confirmed == 'true') {
            $this->getConfig()->set('token', $oauth_token);
            $this->getConfig()->set('token_secret', $oauth_token_secret);

            return true;
        }

        return false;
    }

    /**
     * authorize user
     *
     * 2nd step in OAuth1 dance. Authorizes the user and performs the redirect
     *
     * @todo create URI from Guzzle helper methods
     */
    public function XingAuthorize()
    {
        $redirectResponse = new RedirectResponse("https://api.xing.com/v1/authorize?" . http_build_query(array(
                'oauth_token' => $this->getConfig()->get('token'))
        ), 302);
        $redirectResponse->send();
    }

    /**
     * get access token
     *
     * @param $oauth_verifier string OAuth verifier code
     */
    public function XingAccessToken($oauth_verifier)
    {
        $request = $this->get('access_token?oauth_verifier=' . urlencode($oauth_verifier));

        $response = $request->send();

        $oauth_token = $oauth_token_secret = $user_id = null;
        parse_str((string)$response->getBody());

        if ($response->getStatusCode() == 201) {
            $this->XingUserId = $user_id;
            $this->XingAccessToken = $oauth_token;
            $this->XingAccessTokenSecret = $oauth_token_secret;
        }
    }
}