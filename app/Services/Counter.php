<?php

namespace App\Services;

use App\Contracts\CounterContract;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session;

class Counter implements CounterContract
{
    private int $timeout;
    private Cache $cache;
    private Session $session;
    private $supportTags;

    public function __construct(Cache $cache, Session $session, int $timeout)
    {
        $this->cache = $cache;
        $this->timeout = $timeout;
        $this->session = $session;
        $this->supportTags = method_exists($cache, 'tags');
    }

    public function increment(string $key, array $tags = null): int
    {
        $sessionId = $this->session->getId();
        $counterKey = "blog-post-{$key}-counter";
        $userKey = "blog-post-{$key}-users";

        $cache = $this->supportTags && null !== $tags ? $this->cache->tags($tags) : $this->cache;

        $users = $cache->get($userKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= $this->timeout) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId]) >= $this->timeout) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        $cache->forever($userKey, $usersUpdate);
        if ($cache->has($counterKey)) {
            $cache->increment($counterKey, $difference);
        } else {
            $cache->forever($counterKey, 1);
        }

        return $cache->get($counterKey);
    }
}
