<?php

namespace SolutionForest\FilamentTree\Actions;


use Filament\Actions\Action as BaseAction;
use Filament\Actions\Concerns\CanBeDisabled;
use Filament\Actions\Concerns\CanBeOutlined;
use Filament\Actions\Concerns\CanOpenUrl;
use Filament\Actions\Concerns\HasGroupedIcon;
use Filament\Actions\Concerns\HasTooltip;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Actions\Contracts\Groupable;
use Filament\Actions\Contracts\HasRecord;
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentTree\Actions\Modal\Action as ModalAction;
use SolutionForest\FilamentTree\Concern\BelongsToTree;

class Action extends BaseAction implements Groupable, HasRecord
{
    use CanBeDisabled;
    use CanBeOutlined;
    use CanOpenUrl;
    use HasGroupedIcon;
    use HasTooltip;
    use InteractsWithRecord;
    use BelongsToTree;

    protected string $view = 'filament-tree::actions.link-action';

    public function button(): static
    {
        $this->view('filament-tree::actions.button-action');

        return $this;
    }

    public function grouped(): static
    {
        $this->view('filament-tree::actions.grouped-action');

        return $this;
    }

    public function iconButton(): static
    {
        $this->view('filament-tree::actions.icon-button-action');

        return $this;
    }

    public function link(): static
    {
        $this->view('filament-tree::actions.link-action');

        return $this;
    }

    protected function getLivewireCallActionName(): string
    {
        return 'callMountedTreeAction';
    }

    protected static function getModalActionClass(): string
    {
        return ModalAction::class;
    }

    public function makeModalAction(string $name): ModalAction
    {
        /** @var ModalAction $action */
        $action = parent::makeModalAction($name);

        return $action;
    }

    protected function getDefaultEvaluationParameters(): array
    {
        return array_merge(parent::getDefaultEvaluationParameters(), [
            'record' => $this->resolveEvaluationParameter(
                'record',
                fn (): ?Model => $this->getRecord(),
            ),
        ]);
    }

    public function getRecordTitle(?Model $record = null): string
    {
        $record ??= $this->getRecord();

        return $this->getCustomRecordTitle($record) ?? $this->getLivewire()->getTreeRecordTitle($record);
    }

    public function getModel(): string
    {
        return $this->getCustomModel() ?? $this->getLivewire()->getModel();
    }
}
