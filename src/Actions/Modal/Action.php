<?php

namespace SolutionForest\FilamentTree\Actions\Modal;

use Filament\Actions\StaticAction as BaseAction;

class Action extends BaseAction
{
    protected string $view = 'filament-tree::actions.modal.actions.button-action';

    public function button(): static
    {
        $this->view(static::$view);

        return $this;
    }
}
