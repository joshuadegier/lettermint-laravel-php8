<?php

namespace Lettermint\Laravel\Events;

use Lettermint\Laravel\Webhooks\Data\MessageFailedData;
use Lettermint\Laravel\Webhooks\Data\WebhookEnvelope;

final class MessageFailed extends LettermintWebhookEvent
{
    public function __construct(
        public WebhookEnvelope $envelope,
        public MessageFailedData $data,
    ) {}

    public function getEnvelope(): WebhookEnvelope
    {
        return $this->envelope;
    }
}
