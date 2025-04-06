<?php

namespace App\Services\Interactions;

use App\Repositories\Interfaces\SubscriptionRepositoryInterface;

class SubscriptionService
{
    public function __construct(
        protected SubscriptionRepositoryInterface $subscriptionRepository
    )
    {
    }

    public function subscribe(string $subscriberName, string $channelName)
    {
        return $this->subscriptionRepository->createSubscription([
            'username' => $subscriberName,
            'channel_name' => $channelName
        ]);
    }

    public function unsubscribe(string $subscriberName, string $channelName)
    {
        return $this->subscriptionRepository->deleteSubscription($subscriberName, $channelName);
    }

    public function getSubscriber(string $channelName)
    {
        return $this->subscriptionRepository->getSubscribers($channelName);
    }

    public function getSubscription(string $username)
    {
        return $this->subscriptionRepository->getSubscriptions($username);
    }
}
