<?php

namespace App\Repositories\Interfaces;

interface SubscriptionRepositoryInterface
{
    public function createSubscription(array $data);

    public function deleteSubscription($subscriberName, $channelName);

    public function getSubscribers($channelName);

    public function getSubscriptions($subscriberName);
}
