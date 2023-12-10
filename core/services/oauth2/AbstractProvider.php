<?php

declare(strict_types=1);

namespace core\services\oauth2;

use app\helpers\Random;
use core\helpers\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

abstract class AbstractProvider {

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var string
     */
    protected $redirectUri;

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $domain = '';

    /**
     * @var string
     */
    protected $apiDomain = '';

    /**
     * @var string
     */
    protected $apiUrl = '';

    /**
     * @var string
     */
    protected $oauthstate = '';

    /**
     * @var array
     */
    protected $scopes = [];

    /**
     * @var string
     */
    protected $email;

    /**
     * @var array
     */
    protected $options;

    public function __construct(array $config) {
        $this->clientId = $config['client_id'];
        $this->clientSecret = $config['client_secret'];
        $this->redirectUri = $config['redirect_uri'];
        $this->state = Random::generateToken();
        $this->options = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'state' => $this->state
        ];
        $this->client = new Client(['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function saveState() : void {
        $oauth2state = $this->oauthstate;
        session()->$oauth2state = $this->state;
    }

    public function isAuthorized(Request $request) : bool {
        $session = session();

        $error = $request->get->get('error');
        $code = $request->get->get('code');
        $state = $request->get->get('state');

        $stateName = $this->oauthstate;

        $oauth2state = isset($session->$stateName) ? $session->$stateName : null;

        if(!empty($error) || empty($code) || empty($state) || ($state !== $oauth2state)) {
            return false;
        }
        unset($session->$stateName);

        $token = $this->fetchAccessTokenWithAuthCode($code);

        if($token === false) {
            return false;
        }
        $userInfo = $this->getUserInfo($token['access_token']);

        if($userInfo == false || empty($userInfo)) {
            return false;
        }
        $email = $userInfo['email'] ?? $userInfo[0]['email'] ?? "";

        if(empty($email)) {
            return false;
        }
        $this->email = $email;
        return true;
    }

    private function fetchAccessTokenWithAuthCode(string $code) : array|false {
        try {
            $oauthstate = $this->oauthstate;
            $oauth2state = session()->$oauthstate;
            $params = [
                'code' => $code,
                'redirect_uri' => $this->redirectUri,
                'state' => $oauth2state,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'authorization_code'
            ];
            $options = [
                'form_params' => $params,
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ];
            $response = $this->client->post($this->apiUrl, $options);

            if($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents(), true);
            }
        }catch(RequestException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function getUserInfo(string $token) : array|false {
        try {
            $headers = [
                'Authorization' => "Bearer $token",
                'Accept' => 'application/json',
            ];
            $response = $this->client->get($this->apiDomain, [
                'headers' => $headers
            ]);
            if($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents(), true);
            }
        } catch(RequestException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    protected function buildQuery(array $params) : string {
        return trim($this->getBaseAuthorizationUrl(), '?&') . '?' . http_build_query($params);
    }

    abstract public function getBaseAuthorizationUrl() : string;
 
    abstract public function createAuthorizationUrl() : string;
}
?>