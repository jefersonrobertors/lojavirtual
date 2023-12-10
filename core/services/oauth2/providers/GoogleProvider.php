<?php

declare(strict_types=1);

namespace core\services\oauth2\providers;

use core\services\oauth2\AbstractProvider;

class GoogleProvider extends AbstractProvider {

    /**
     * @var string
     */
    protected $domain = 'https://accounts.google.com';

    /**
     * @var string
     */
    protected $apiDomain = 'https://www.googleapis.com/oauth2/v1/userinfo';

    /**
     * @var string
     */
    protected $apiUrl = 'https://oauth2.googleapis.com/token';

    /**
     * @var array
     */
    protected $scopes = [
        'email', 'profile'
    ];

    /**
     * @var string
     */
    protected $oauthstate = 'oauth2_state_google';

    public function getBaseAuthorizationUrl() : string {
        return $this->domain . '/o/oauth2/v2/auth/oauthchooseaccount';
    }

    public function createAuthorizationUrl() : string {
        $params = $this->options + [
            'scope' => join(' ', $this->scopes),
            'response_type' => 'code',
            'access_type' => 'online',
        ];
        $this->saveState();
        return $this->buildQuery($params);
    }
}
?>