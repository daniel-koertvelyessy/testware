<?php

namespace App\ViewModel;

use App\Equipment;
use Illuminate\Support\Collection;

class EquipmentViewModel
{
    public function __construct(public Equipment $equipment) {}

    public static function collection(Collection $equipmentCollection): Collection
    {
        return $equipmentCollection->map(fn ($equipment) => new self($equipment));
    }

    public function link(): string
    {
        return route('equipment.show', $this->equipment);
    }

    public function name(): string
    {
        return $this->equipment->eq_name ?? '–';
    }

    public function inventoryNumber(): string
    {
        return $this->equipment->eq_inventar_nr ?? '–';
    }

    public function storageLabel(): string
    {
        return $this->equipment->storage->storage_label ?? '<span class="fas fa-exclamation-circle text-warning"></span> <span class="text-warning text-sm">keine Zuordnung</span>';
    }

    public function stateLabel(): string
    {
        return $this->equipment->EquipmentState?->estat_label ?? '–';
    }

    public function stateColor(): string
    {
        return $this->equipment->EquipmentState?->estat_color ?? 'secondary';
    }

    public function hasQualifiedUsers(): bool
    {
        return $this->equipment->EquipmentQualifiedUser->count() > 0;
    }

    public function isTested(): bool
    {
        return $this->equipment->tested_count > 0;
    }

    public function controlProductLabel(): string
    {
        return $this->equipment->controlProductIcon(); // Assuming this returns safe HTML
    }

    public function controlDueDates(): array
    {
        return $this->equipment->ControlEquipment
            ->filter(fn ($item) => ! $item->isInitialTest() && is_null($item->archived_at))
            ->map(function ($controlItem) {
                $class = '';
                $date = '';
                if ($controlItem->qe_control_date_due) {
                    if ($controlItem->qe_control_date_due < now()) {
                        $class = 'bg-danger text-white';
                    } elseif ($controlItem->qe_control_date_due < now()->addWeeks($controlItem->qe_control_date_warn)) {
                        $class = 'bg-warning text-white';
                    }

                    $date = $controlItem->qe_control_date_due->format('Y-m-d');
                }

                return [
                    'date' => $date,
                    'class' => $class,
                ];
            })->values()->toArray();
    }
}
