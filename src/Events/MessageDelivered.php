<?php

namespace Lettermint\Laravel\Events;

use Lettermint\Laravel\Webhooks\Data\MessageDeliveredData;
use Lettermint\Laravel\Webhooks\Data\WebhookEnvelope;

final class MessageDelivered extends LettermintWebhookEvent
{
    public function __construct(
        public WebhookEnvelope $envelope,
        public MessageDeliveredData $data,
    ) {}

    public function getEnvelope(): WebhookEnvelope
    {
        return $this->envelope;
    }
}
