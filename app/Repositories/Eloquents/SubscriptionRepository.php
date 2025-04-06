<?php

namespace App\Repositories\Eloquents;

use App\Models\Interactions\Subscription;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{

    public function createSubscription(array $data)
    {
        return Subscription::create($data);
    }

    public function deleteSubscription($subscriberName, $channelName)
    {
        return Subscription::where('username', $subscriberName)->where('channel_name', $channelName)->delete();
    }

    public function getSubscribers($channelName)
    {
        return Subscription::where('channel_name', $channelName)->with('subscriber')->get();
    }

    public function getSubscriptions($subscriberName)
    {
        return Subscription::where('username', $subscriberName)->with('channel')->get();
    }
}
