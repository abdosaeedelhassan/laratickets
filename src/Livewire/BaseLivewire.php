<?php

namespace AsayDev\LaraTickets\Livewire;

use App\Exports\DataTableExport;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class BaseLivewire extends DataTableComponent
{


    public $loadingIndicator = true;
    public $searchEnabled = true;
    public $paginationTheme = 'bootstrap-4';
    public $searchDebounce = 400;


    public $report_title = 'Report';


    public array $bulkActions = [
        'exportAsPdf' => 'Export as Pdf',
        'exportAsExcel' => 'Export as Excel',
    ];

    public function getReportData()
    {
        $columns = array_filter($this->columns(), function ($column) {
            return !$column->hidden && $column->text != 'الإجراءات';
        });
        $rows = [];
        foreach ($this->rows as $one_row) {
            $row = json_decode($one_row, true);
            $temp = [];
            foreach ($columns as $column) {
                if ($column->formatCallback) {
                    $temp[$column->column] = $column->formatted($one_row);
                } else {
                    if (str_contains($column->column, '.')) {
                        $pos = 0;
                        $container = $row;
                        while ($pos < sizeof(explode('.', $column->column))) {
                            $container = $container[explode('.', $column->column)[$pos]];
                            $pos++;
                        }
                        $temp[$column->column] = $container;
                    } else {
                        $temp[$column->column] = $row[$column->column];
                    }
                }
            }
            array_push($rows, $temp);
        }
        $report_data = [
            'heading' => array_map(function ($column) {
                return $column->text;
            }, $columns),
            'columns' => array_map(function ($column) {
                return $column->column;
            }, $columns),
            'rows' => $rows,
            'report_title' => $this->report_title
        ];
        return $report_data;
    }

    public function exportAsPdf()
    {
        try {
            $this->emit('exportData', json_encode($this->getReportData()));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function exportAsExcel()
    {
        try {
            return Excel::download(new DataTableExport($this->getReportData()), $this->report_title . '.xlsx');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


    /**
     * @inheritDoc
     */
    public function query(): Builder
    {
        // TODO: Implement query() method.
    }

    /**
     * @inheritDoc
     */
    public function columns(): array
    {
        // TODO: Implement columns() method.
    }
}
