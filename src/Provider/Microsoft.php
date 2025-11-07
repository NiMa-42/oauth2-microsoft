<?php namespace Stevenmaguire\OAuth2\Client\Provider;

use GuzzleHttp\Psr7\Uri;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Microsoft extends AbstractProvider
{
    public array $defaultScopes = ["User.Read profile openid email"];

    protected string $urlAuthorize = 'https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize';

    protected string $urlAccessToken = 'https://login.microsoftonline.com/organizations/oauth2/v2.0/token';

    protected string $urlResourceOwnerDetails = 'https://apis.microsoftonline.net/v5.0/me';

    public function getBaseAuthorizationUrl(): string
    {
        return $this->urlAuthorize;
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return $this->urlAccessToken;
    }

    protected function getDefaultScopes(): array
    {
        return $this->defaultScopes;
    }

    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if (isset($data['error'])) {
            throw new IdentityProviderException(
                (isset($data['error']['message']) ? $data['error']['message'] : $response->getReasonPhrase()),
                $response->getStatusCode(),
                $response
            );
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token): MicrosoftResourceOwner
    {
        return new MicrosoftResourceOwner($response);
    }

    public function getResourceOwnerDetailsUrl(): Uri
    {
        return new Uri($this->urlResourceOwnerDetails);
    }

    public function getAuthorizationHeaders($token = null): ?string
    {
        return ["Authorization" => "Bearer $token"];
    }
}
