<?php namespace Stevenmaguire\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class MicrosoftResourceOwner implements ResourceOwnerInterface
{
    protected array $response;

    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    public function getId(): ?string
    {
        return $this->response['id'] ?: null;
    }

    public function getEmail(): ?string
    {
        return $this->response['mail'] ?: null;
    }

    public function getDisplayName(): ?string
    {
        return $this->response['displayName'] ?: null;
    }

    public function getPhone(): ?string
    {
        return $this->response['businessPhones'] ?: null;
    }

    public function getJobTitle(): ?string
    {
        return $this->response['jobTitle'] ?: null;
    }

    public function getName(): ?string
    {
        return $this->response['givenName'] ?: null;
    }

    public function getLastName(): ?string
    {
        return $this->response['surname'] ?: null;
    }

    public function getUrls(): ?string
    {
        return isset($this->response['link']) ? $this->response['link'].'/cid-'.$this->getId() : null;
    }

    public function toArray(): array
    {
        return $this->response;
    }
}
