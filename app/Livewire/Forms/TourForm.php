<?php

namespace App\Livewire\Forms;

use App\Enums\TourPaymentType;
use App\Models\TourDestination;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;
use Livewire\WithFileUploads;

class TourForm extends Form
{
    #[Session]
    #[Validate('required|string|min:3|max:120')]
    public string $title = '';

    #[Session]
    #[Validate('required|int|min:0|max:20')]
    public int $number_of_nights = 0;

    #[Session]
    #[Validate('required|string|min:2|max:3')]
    public string $airline_code = '';

    #[Session]
    public bool $is_inbound = true;

    #[Session]
    public TourPaymentType $payment_type = TourPaymentType::INSTALLMENT;

    #[Session]
    public ?int $origin_id = null;

    #[Session]
    public string $image_url = '';
    public string $image_alt = '';
}
