<?php

namespace App\Imports;

use App\Models\TonicData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;

use PhpOffice\PhpSpreadsheet\Shared\Date;

class TonicDataImport implements ToModel, WithChunkReading, WithBatchInserts,ShouldQueue//, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $data = new TonicData([

            // даты в экселе - жесть! excelToDateTimeObject() дает php object...
            // пока неясно что далее, пока делаю строки дня и времени.
            'day' => (Date::excelToDateTimeObject($row[0]))->format('Y-m-d'),
            'time' => (Date::excelToDateTimeObject($row[1]))->format('H:i:s'),
            'hour_of_day' => (int)$row[2],
            'view' => (int)$row[3],
            'term_view' => (int)$row[4],
            'ad_click' => (int)$row[5],
            'clicks' => (int)$row[6],
            'revenue_usd' => (int)$row[7],
            'subid1' => (string)$row[8],
            'subid2' => (string)$row[9],
            'subid3' => (string)$row[10],
            'subid4' => (string)$row[11],
            'campaign' => (string) $row[12],
            'country' => (string) $row[13],
            'keyword' => (string) $row[14],
            'day_of_week' => (int)$row[15],
            'affiliate_network' => (string)$row[16],

        ]);

        //dd($data);

        return $data;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
    public function batchSize(): int
    {
        return 1000;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
