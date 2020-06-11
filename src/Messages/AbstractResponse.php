<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\IyzipayResource;
use JsonException;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse implements RedirectResponseInterface
{
    /** @var IyzipayResource */
    private $response;

    public function __construct(RequestInterface $request, IyzipayResource $data)
    {
        parent::__construct($request, $data);
        $this->setResponse($data);
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return !('success' !== $this->response->getStatus());
    }

    /**
     * @return mixed
     * @throws JsonException
     */
    public function getData()
    {
        return $this->data = json_decode($this->response->getRawResult(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return IyzipayResource
     */
    public function getResponse(): IyzipayResource
    {
        return $this->response;
    }

    /**
     * @param IyzipayResource $response
     */
    public function setResponse(IyzipayResource $response): void
    {
        $this->response = $response;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        if (!empty($this->response->getErrorMessage())) {
            return $this->response->getErrorCode() . ' : ' . $this->response->getErrorMessage();
        }

        return null;
    }

    public function getRedirectMethod(): string
    {
        return 'POST';
    }

}
