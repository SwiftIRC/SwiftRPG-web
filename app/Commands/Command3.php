<?php

namespace App\Commands;

use App\Http\Response\Reward;
use App\Models\Command;
use App\Models\User;

abstract class Command3
{
    protected $quantity;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    abstract protected function execute(object $input): \Illuminate\Http\JsonResponse;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    abstract protected function queue(array $input = []): \Illuminate\Http\Response;

    /**
     * Returns an object with the following properties:
     * - type: string (i.e., gold, logs, etc.)
     * - quantity: integer
     * - total: integer
     *
     * @return array([ 'type' => string, 'quantity' => integer, 'total' => integer ])
     */
    abstract protected function generateReward(User $user, Command $command): Reward;

}
