<?php

namespace App\Imports;

use App\Mail\ImportUser;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cookie;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Events\BeforeImport;
use Throwable;

class UsersImport implements
    ToModel,
    ShouldQueue,
    WithValidation,
    SkipsOnError,
    SkipsOnFailure,
    WithHeadingRow,
    WithBatchInserts,
    WithChunkReading,
    WithEvents
{
    use SkipsErrors,
    SkipsFailures,
    Importable,
    RegistersEventListeners;

    public static $acceptedRows = 0;

    public static $failedRows = 0;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        self::$acceptedRows ++;

        return new User([
            'first_name'     => $row['first_name'],
            'second_name'    => $row['second_name'],
            'family_name' => $row['family_name'],
            'uid' => $row['uid']
        ]);
    }

    public function rules(): array
    {
        return [
             // Can also use callback validation rules
             '*.first_name' => 'required',
             '*.second_name' => 'required',
             '*.family_name' => 'required',
             '*.uid' => 'required'
        ];
    }

    // public function onError(Throwable $error)
    // {

    // }
    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failure)
    {
        // work as per chuncks only not all chuncks

        self::$failedRows += count($failure);
    }

    public function batchSize(): int
    {
        return 5000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public static function beforeImport(BeforeImport $event)
    {
        //** doesnt work */
        // $worksheet = $event->reader->getActiveSheet();

        // $highestRow = $worksheet->getHighestRow();

        // dd($highestRow, $worksheet);
    }

    public static function afterImport(AfterImport $event)
    {
        //** save success rows & failure rows in a session &
        // access it from mail class because event doesnt have access to $this */

        session()->forget(['failedRows', 'acceptedRows']);

        session()->put('failedRows', self::$failedRows);

        session()->put('acceptedRows', self::$acceptedRows);

        Mail::to('sheirytaher@gmail.com')->send(new ImportUser());
    }
}
