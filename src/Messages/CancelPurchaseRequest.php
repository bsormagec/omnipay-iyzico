<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\Cancel;
use Iyzipay\Request\CreateCancelRequest;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

class CancelPurchaseRequest extends AbstractRequest
{

    /**
     * @return CreateCancelRequest
     */
    public function getData(): CreateCancelRequest
    {
        $request = new CreateCancelRequest();
        $request->setLocale($this->getLocale());
        $request->setPaymentId($this->getPaymentId());
        $request->setIp($this->getClientIp());

        return $request;
    }

    /**
     * @param mixed $data
     * @return ResponseInterface|CancelPurchaseResponse
     * @throws InvalidResponseException
     */
    public function sendData($data): CancelPurchaseResponse
    {
        try {
            $options = $this->getOptions();

            return new CancelPurchaseResponse($this, Cancel::create($data, $options));
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }
}