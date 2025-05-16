<?php

namespace App\Jobs;

use App\ControlEquipment;
use App\DelayedControlEquipment;
use App\Equipment;
use App\EquipmentHistory;
use App\Notifications\EquipmentTestIsOverdue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class CheckEquipmentTestDueDates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::info(__('Prüfung für überfällige Geräteprüfungen wurde gestartet um '.date('Y-m-d H:i')));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * place all overdue Equipment control-event into this array
         */
        $delayedControlEquipment = [];
        foreach (ControlEquipment::all() as $controlEquipment) {

            /**
             * Check if the control-event is overdue
             *  report it to DelayedControlEvent
             */
            if ($controlEquipment->qe_control_date_due < now()) {

                $equipment = Equipment::find($controlEquipment->equipment_id);

                (new DelayedControlEquipment)->reportEquipment($equipment);
                $delayedControlEquipment[] = $controlEquipment;

                if ((new Equipment)->lockEquipment($equipment)) {
                    (new EquipmentHistory)->add(
                        __('Prüfung überfällig'),
                        __('Die Prüfung :testname des Gerätes :eqname ist überfällig. Das Geräte wurde daher gesperrt!',
                            [
                                'eqname' => $controlEquipment->Equipment->eq_name,
                                'testname' => $controlEquipment->Anforderung->an_name,
                            ]),
                        $controlEquipment->equipment_id
                    );
                }
            }

        }

        if (count($delayedControlEquipment) > 0) {
            /**
             *  Fetch all qualified employess from equipment and send
             *  a notification that 'their' equipment should be tested
             *  now.
             */
            foreach ($delayedControlEquipment as $controlEquipment) {
                foreach ($controlEquipment->Equipment->EquipmentQualifiedUser as $qualifiedUser) {

                    $qualifiedUser->user->notify(new EquipmentTestIsOverdue($controlEquipment));
                }

            }
        }
    }
}
