<?php

namespace App\Http\Response;

use Illuminate\Support\Collection;

class Quest
{
    public $response;

    public function __construct(mixed $response)
    {
        $this->response = $response;
    }

    public function toArray(): array
    {
        return [
            'complete_steps' => $this->response->completeSteps,
            'details' => [
                'id' => $this->response->id,
                'name' => $this->response->name,
                'description' => $this->response->description,
            ],
            'step_details' => [
                'id' => $this->response->requested_step_id,
                'output' => $this->response->step->output,
            ],
            'incomplete_dependencies' => $this->response->incompleteDependencies,
            'incomplete_steps' => $this->response->incompleteSteps,
        ];
    }

    public function collect(): Collection
    {
        return collect($this->toArray());
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    public function __debugInfo(): array
    {
        return $this->toArray();
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __isset($name)
    {
        return isset($this->$name);
    }
}
