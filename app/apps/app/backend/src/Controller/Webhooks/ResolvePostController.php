<?php

declare(strict_types=1);

namespace Crissanclick\Apps\App\Backend\Controller\Webhooks;

use Exception;
use Shopify\Clients\HttpHeaders;
use Shopify\Exception\InvalidWebhookException;
use Shopify\Webhooks\Registry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ResolvePostController
{
    public function __invoke(Request $request): JsonResponse
    {
        $topic = $request->headers->get(HttpHeaders::X_SHOPIFY_TOPIC);
        try {
            $response = Registry::process($request->headers->all(), $request->getContent());
            if (!$response->isSuccess()) {
                return $this->response(
                    'Failed to process' . $topic . ' webhook',
                    500
                );
            }
        } catch (InvalidWebhookException) {
            return $this->response(
                'Got invalid webhook request for topic ' . $topic,
                401
            );
        } catch (Exception) {
            return $this->response(
                'Got an exception when handling ' . $topic . ' webhook',
                500
            );
        }
        return $this->response('Webhook processed successfully');
    }

    public function response(string $responseMessage, int $errorCode = 200): JsonResponse
    {
        return new JsonResponse(
            ['message' => $responseMessage],
            $errorCode
        );
    }
}
