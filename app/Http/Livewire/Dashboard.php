<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;

class Dashboard extends Component
{
    public $showDataLabels = false;
    public $firstRun = false;

    public function render()
    {

        $transactions = [
            [
                'id' => 1,
                'date' => '2021-01-01',
                'amount' => 50,
            ],
            [

                'id' => 2,
                'date' => '2021-01-02',
                'amount' => 60,
            ],
            [

                'id' => 3,
                'date' => '2021-01-03',
                'amount' => 80,
            ],
            [

                'id' => 4,
                'date' => '2021-01-04',
                'amount' => 70,
            ],
            [

                'id' => 5,
                'date' => '2021-01-05',
                'amount' => 50,
            ],
            [

                'id' => 6,
                'date' => '2021-01-05',
                'amount' => 60,
            ],
            [

                'id' => 7,
                'date' => '2021-01-05',
                'amount' => 70,
            ],
            [

                'id' => 8,
                'date' => '2021-01-05',
                'amount' => 80,
            ],
            [

                'id' => 9,
                'date' => '2021-01-05',
                'amount' => 90,
            ],
        ];

        $transactions = collect($transactions)->map(function ($data) {
            return (object) [
                'id' => $data['id'],
                'date' => $data['date'],
                'amount' => $data['amount'],
            ];
        });

        $lineChartModel = $transactions
        ->reduce(function ($lineChartModel, $data) use ($transactions) {
            $index = $transactions->search($data);

            $amountSum = $transactions->take($index + 1)->sum('id');

            if ($index == 6) {
                $lineChartModel->addMarker(7, $amountSum);
            }

            if ($index == 11) {
                $lineChartModel->addMarker(12, $amountSum);
            }

            return $lineChartModel->addPoint($data->date, $data->amount, ['id' => $data->date]);
        }, LivewireCharts::lineChartModel()
            ->setTitle('Grafik Penjualan')
            ->setAnimated($this->firstRun)
            ->withOnPointClickEvent('onPointClick')
            ->setSmoothCurve()
            ->setXAxisVisible(true)
            ->setDataLabelsEnabled($this->showDataLabels)
            // ->sparklined()
        );

        return view('livewire.dashboard', [
            'lineChartModel' => $lineChartModel,
        ])->extends('layouts.app');
    }
}
