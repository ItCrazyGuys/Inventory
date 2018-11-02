<?php

namespace App\Provider;

/**
 * Get agentsDn for yesterday from cucm
 *
 * Interface AgentsDnProvider
 * @package App\Provider
 */
interface AgentsDnProvider
{
    public function getAgentsDn($cucm);
}
