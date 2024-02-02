<?php
namespace App\Http\Services\Params\Appointments;

use App\Http\Services\Params\BaseServiceParams;

class StoreServiceParams extends BaseServiceParams
{
    public $patient_id;
    public $doctor_id;
    public $start_date;
    public $end_date;
    public $status;
    public $color;
    public $roomName; // Add the roomName property

    public function __construct(
        int $patient_id,
        int $doctor_id,
        string $start_date,
        string $end_date,
        string $roomName, // Include roomName in the constructor parameters
        string $status = 'pending',
        string $color = 'yellow'
    ) {
        parent::__construct(); // Assuming this is doing some common initialization in the BaseServiceParams

        // Assign values to properties
        $this->patient_id = $patient_id;
        $this->doctor_id = $doctor_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->roomName = $roomName; // Assign roomName
        $this->status = $status;
        $this->color = $color;
    }
}


