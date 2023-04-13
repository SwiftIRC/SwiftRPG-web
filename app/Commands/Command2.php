<?php

namespace App\Commands;

abstract class Command2
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
    abstract protected function generateReward($total): array;

}
