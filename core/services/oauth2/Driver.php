<?php

namespace core\services\oauth2;

use core\services\oauth2\providers\GithubProvider;
use core\services\oauth2\providers\GoogleProvider;

final class Driver {

    /** @var string */
    public const GITHUB = 'github';

    /** @var string */
    public const GOOGLE = 'google';

    private array $driversAliases = [
        'github' => GithubProvider::class,
        'google' => GoogleProvider::class,
    ];

    public static function create() : self {
        return new self;
    }

    public function getDriver(string $name) : mixed {
        $name = strtolower($name);

        if(!isset($this->driversAliases[$name])) {
            return null;
        }
        $driver = $this->driversAliases[$name];

        if(!is_subclass_of($driver, AbstractProvider::class)) {
            return null;
        }
        return new $driver($this->getAuthConfig($name));
    }

    public function createGithubAuthorizationUrl() : string {
        return 
        $this->createAuthorizationUrl(
            GithubProvider::class, 
            $this->getAuthConfig(Driver::GITHUB)
        );
    }

    public function createGoogleAuthorizationUrl() : string {
        return 
        $this->createAuthorizationUrl(
            GoogleProvider::class, 
            $this->getAuthConfig(Driver::GOOGLE)
        );
    }

    private function createAuthorizationUrl(string $providerNamespace, array $config) : string {
        $authorization_url = "";
        $provider = new $providerNamespace($config);

        if(is_subclass_of($provider, AbstractProvider::class)) {
            $authorization_url = $provider->createAuthorizationUrl();
        }
        return $authorization_url;
    }

    public function getAuthConfig(string $name) : array {
        $config = match($name) {
            Driver::GITHUB => [
                'client_id'     => env('GITHUB_OAUTH2_CLIENT_ID'),
                'client_secret' => env('GITHUB_OAUTH2_CLIENT_SECRET'),
            ],
            Driver::GOOGLE => [
                'client_id'     => env('GOOGLE_OAUTH2_CLIENT_ID'),
                'client_secret' => env('GOOGLE_OAUTH2_CLIENT_SECRET'),
            ],
            default => [
                'client_id'     => null,
                'client_secret' => null,
                'redirect_uri'  => null
            ]
        };
        if(!isset($config['redirect_uri'])) {
            $config['redirect_uri'] = route("/oauth/$name/callback");
        }
        return $config;
    }
}
?>