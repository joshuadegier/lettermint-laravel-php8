<?php

namespace Lettermint\Laravel\Webhooks;

use InvalidArgumentException;
use Lettermint\Laravel\Events\LettermintWebhookEvent;
use Lettermint\Laravel\Events\MessageCreated;
use Lettermint\Laravel\Events\MessageDelivered;
use Lettermint\Laravel\Events\MessageFailed;
use Lettermint\Laravel\Events\MessageHardBounced;
use Lettermint\Laravel\Events\MessageInbound;
use Lettermint\Laravel\Events\MessageSent;
use Lettermint\Laravel\Events\MessageSoftBounced;
use Lettermint\Laravel\Events\MessageSpamComplaint;
use Lettermint\Laravel\Events\MessageSuppressed;
use Lettermint\Laravel\Events\MessageUnsubscribed;
use Lettermint\Laravel\Events\WebhookTest;
use Lettermint\Laravel\Webhooks\Data\MessageCreatedData;
use Lettermint\Laravel\Webhooks\Data\MessageDeliveredData;
use Lettermint\Laravel\Webhooks\Data\MessageFailedData;
use Lettermint\Laravel\Webhooks\Data\MessageHardBouncedData;
use Lettermint\Laravel\Webhooks\Data\MessageInboundData;
use Lettermint\Laravel\Webhooks\Data\MessageSentData;
use Lettermint\Laravel\Webhooks\Data\MessageSoftBouncedData;
use Lettermint\Laravel\Webhooks\Data\MessageSpamComplaintData;
use Lettermint\Laravel\Webhooks\Data\MessageSuppressedData;
use Lettermint\Laravel\Webhooks\Data\MessageUnsubscribedData;
use Lettermint\Laravel\Webhooks\Data\WebhookEnvelope;
use Lettermint\Laravel\Webhooks\Data\WebhookTestData;

final class WebhookEventType
{
    public const MESSAGE_CREATED = 'message.created';
    public const MESSAGE_SENT = 'message.sent';
    public const MESSAGE_DELIVERED = 'message.delivered';
    public const MESSAGE_HARD_BOUNCED = 'message.hard_bounced';
    public const MESSAGE_SOFT_BOUNCED = 'message.soft_bounced';
    public const MESSAGE_SPAM_COMPLAINT = 'message.spam_complaint';
    public const MESSAGE_FAILED = 'message.failed';
    public const MESSAGE_SUPPRESSED = 'message.suppressed';
    public const MESSAGE_UNSUBSCRIBED = 'message.unsubscribed';
    public const MESSAGE_INBOUND = 'message.inbound';
    public const WEBHOOK_TEST = 'webhook.test';

    private static array $instances = [];

    public string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function from(string $value): self
    {
        $instance = self::tryFrom($value);

        if ($instance === null) {
            throw new InvalidArgumentException("Invalid webhook event type: {$value}");
        }

        return $instance;
    }

    public static function tryFrom(string $value): ?self
    {
        $validValues = [
            self::MESSAGE_CREATED,
            self::MESSAGE_SENT,
            self::MESSAGE_DELIVERED,
            self::MESSAGE_HARD_BOUNCED,
            self::MESSAGE_SOFT_BOUNCED,
            self::MESSAGE_SPAM_COMPLAINT,
            self::MESSAGE_FAILED,
            self::MESSAGE_SUPPRESSED,
            self::MESSAGE_UNSUBSCRIBED,
            self::MESSAGE_INBOUND,
            self::WEBHOOK_TEST,
        ];

        if (!in_array($value, $validValues, true)) {
            return null;
        }

        if (!isset(self::$instances[$value])) {
            self::$instances[$value] = new self($value);
        }

        return self::$instances[$value];
    }

    public static function MessageCreated(): self
    {
        return self::from(self::MESSAGE_CREATED);
    }

    public static function MessageSent(): self
    {
        return self::from(self::MESSAGE_SENT);
    }

    public static function MessageDelivered(): self
    {
        return self::from(self::MESSAGE_DELIVERED);
    }

    public static function MessageHardBounced(): self
    {
        return self::from(self::MESSAGE_HARD_BOUNCED);
    }

    public static function MessageSoftBounced(): self
    {
        return self::from(self::MESSAGE_SOFT_BOUNCED);
    }

    public static function MessageSpamComplaint(): self
    {
        return self::from(self::MESSAGE_SPAM_COMPLAINT);
    }

    public static function MessageFailed(): self
    {
        return self::from(self::MESSAGE_FAILED);
    }

    public static function MessageSuppressed(): self
    {
        return self::from(self::MESSAGE_SUPPRESSED);
    }

    public static function MessageUnsubscribed(): self
    {
        return self::from(self::MESSAGE_UNSUBSCRIBED);
    }

    public static function MessageInbound(): self
    {
        return self::from(self::MESSAGE_INBOUND);
    }

    public static function WebhookTest(): self
    {
        return self::from(self::WEBHOOK_TEST);
    }

    public function isBounce(): bool
    {
        return in_array($this->value, [self::MESSAGE_HARD_BOUNCED, self::MESSAGE_SOFT_BOUNCED], true);
    }

    public function isDeliveryIssue(): bool
    {
        return in_array($this->value, [
            self::MESSAGE_HARD_BOUNCED,
            self::MESSAGE_SOFT_BOUNCED,
            self::MESSAGE_FAILED,
            self::MESSAGE_SUPPRESSED,
        ], true);
    }

    /**
     * Create the appropriate event instance from raw webhook payload.
     *
     * @param  array<string, mixed>  $rawPayload
     */
    public function toEvent(array $rawPayload): LettermintWebhookEvent
    {
        $envelope = WebhookEnvelope::fromArray($rawPayload);
        $data = $rawPayload['data'] ?? [];

        switch ($this->value) {
            case self::MESSAGE_CREATED:
                return new MessageCreated($envelope, MessageCreatedData::fromArray($data));
            case self::MESSAGE_SENT:
                return new MessageSent($envelope, MessageSentData::fromArray($data));
            case self::MESSAGE_DELIVERED:
                return new MessageDelivered($envelope, MessageDeliveredData::fromArray($data));
            case self::MESSAGE_HARD_BOUNCED:
                return new MessageHardBounced($envelope, MessageHardBouncedData::fromArray($data));
            case self::MESSAGE_SOFT_BOUNCED:
                return new MessageSoftBounced($envelope, MessageSoftBouncedData::fromArray($data));
            case self::MESSAGE_SPAM_COMPLAINT:
                return new MessageSpamComplaint($envelope, MessageSpamComplaintData::fromArray($data));
            case self::MESSAGE_FAILED:
                return new MessageFailed($envelope, MessageFailedData::fromArray($data));
            case self::MESSAGE_SUPPRESSED:
                return new MessageSuppressed($envelope, MessageSuppressedData::fromArray($data));
            case self::MESSAGE_UNSUBSCRIBED:
                return new MessageUnsubscribed($envelope, MessageUnsubscribedData::fromArray($data));
            case self::MESSAGE_INBOUND:
                return new MessageInbound($envelope, MessageInboundData::fromArray($data));
            case self::WEBHOOK_TEST:
                return new WebhookTest($envelope, WebhookTestData::fromArray($data));
            default:
                throw new InvalidArgumentException("Unknown webhook event type: {$this->value}");
        }
    }
}
