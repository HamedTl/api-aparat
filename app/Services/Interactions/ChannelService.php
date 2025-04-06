<?php

namespace App\Services\Interactions;

use App\Models\Interactions\Channel;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Services\HelperServices\CacheService;
use App\Services\HelperServices\MediaManagementService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class ChannelService
{

    public function __construct(
        protected ChannelRepositoryInterface $channelRepository,
        protected CacheService $cacheService,
        protected MediaManagementService $mediaManagementService
    )
    {
    }

    public function all()
    {
        return Cache::get('channels');
    }

    public function show(Channel $channel)
    {
        return Cache::get($channel->slug);
    }

    public function channelOwner(Channel $channel)
    {
        return $this->channelRepository->owner($channel);
    }

    /**
     * @throws \Exception
     */
    public function create(object $data)
    {
        if (!is_null($data->avatar))
        {
            $avatar = [
                'file' => $data->avatar,
                'fileName' => time() . "_" . $data->avatar->getClientOriginalName(),
                'filePath' => public_path('images/channels')
            ];
            $this->mediaManagementService->handleFile([$avatar]);
        }

        $this->cacheService->cache_delete('channels');
        $this->cacheService->handleCache($this->channelRepository->model(), 'channels');
        return $this->channelRepository->store([
                'channel_name' => $data->channel_name,
                'owner_user' => request()->user()->username,
                'avatar' => !is_null($data->avatar) ? $avatar['fileName'] : null,
            ]);
    }

    /**
     * @throws \Exception
     */
    public function update(object $data, Channel $channel)
    {
        $channelSelected = $this->channelRepository->find($channel);
        if (!is_null($data->avatar)) {
            File::delete(public_path('images/channels/' . $channelSelected->avatar));

            $avatar = [
                'file' => $data->avatar,
                'fileName' => time() . "_" . $data->avatar->getClientOriginalName(),
                'filePath' => public_path('images/channels')
            ];
            $this->mediaManagementService->handleFile([$avatar]);
        }

        $this->cacheService->cache_delete('channels');
        $this->cacheService->handleCache($this->channelRepository->model());
        return $this->channelRepository->update($channel, [
            'channel_name' => $data->channel_name,
            'owner_user' => request()->user()->username,
            'avatar' => !is_null($data->avatar) ? $avatar['fileName'] : null,
        ]);
    }

    public function activeChannel(Channel $channel)
    {
        $this->cacheService->handleCache($this->channelRepository->model());
        return $this->channelRepository->update($channel, [
            'is_active' => true
        ]);
    }

    public function deActiveChannel(Channel $channel)
    {
        $this->cacheService->handleCache($this->channelRepository->model());
        return $this->channelRepository->update($channel, [
            'is_active' => false
        ]);
    }

    public function delete(Channel $channel)
    {
        $channelSelected = $this->channelRepository->find($channel);
        if (!is_null($channelSelected->avatar)) {
            File::delete(public_path('images/channels/' . $channelSelected->avatar));
        }

        $this->cacheService->cache_delete('channels');
        $this->cacheService->handleCache($this->channelRepository->model());
        return $this->channelRepository->delete($channel);
    }
}
