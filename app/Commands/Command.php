<?php

namespace App\Commands;

abstract class Command
{
    protected $quantity;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    abstract protected function execute(object $input): \Illuminate\Http\JsonResponse;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    abstract protected function log(array $input = []): \Illuminate\Http\JsonResponse;

    /**
     * Returns an object with the following properties:
     * - type: string (i.e., gold, logs, etc.)
     * - quantity: integer
     * - total: integer
     *
     * @return array([ 'type' => string, 'quantity' => integer, 'total' => integer ])
     */
    abstract protected function generateReward($total): array;

}
