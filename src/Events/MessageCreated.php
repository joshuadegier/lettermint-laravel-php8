<?php

namespace Lettermint\Laravel\Events;

use Lettermint\Laravel\Webhooks\Data\MessageCreatedData;
use Lettermint\Laravel\Webhooks\Data\WebhookEnvelope;

final class MessageCreated extends LettermintWebhookEvent
{
    public function __construct(
        public WebhookEnvelope $envelope,
        public MessageCreatedData $data,
    ) {}

    public function getEnvelope(): WebhookEnvelope
    {
        return $this->envelope;
    }
}
