<?php

declare(strict_types=1);

namespace core\services\oauth2\providers;

use core\services\oauth2\AbstractProvider;

class GithubProvider extends AbstractProvider {

    /**
     * @var string
     */
    protected $domain = 'https://github.com';

    /**
     * @var string
     */
    protected $apiUrl = 'https://github.com/login/oauth/access_token';

    /**
     * @var string
     */
    protected $apiDomain = 'https://api.github.com/user/emails';

    /**
     * @var array
     */
    protected $scopes = [
        'user:email'
    ];

    /**
     * @var string
     */
    protected $oauthstate = 'oauth2_state_github';

    public function __construct(array $config) {
        parent::__construct($config);
    }

    public function getBaseAuthorizationUrl() : string {
        return $this->domain . '/login/oauth/authorize';
    }

    public function createAuthorizationUrl() : string {
        $params = [
            'scope' => join(' ', $this->scopes),
        ] + $this->options;

        $this->saveState();

        return $this->buildQuery($params);
    }
}
?>