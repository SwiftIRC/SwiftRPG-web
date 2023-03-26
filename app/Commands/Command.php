<?php

namespace App\Commands;

abstract class Command
{
    protected $quantity;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    abstract protected function execute(): \Illuminate\Http\JsonResponse;

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
