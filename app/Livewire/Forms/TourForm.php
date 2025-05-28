<?php

namespace App\Livewire\Forms;

use App\Enums\TourPaymentType;
use App\Models\TourDestination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;
use Livewire\WithFileUploads;

class TourForm extends Form
{
    /**
     * Step 1
     */
    #[Session]
    public string $title = '';

    #[Session]
    public int $number_of_nights = 0;

    #[Session]
    public string $airline_code = '';

    #[Session]
    public string $image_url = '';
    public string $image_alt = '';

    /**
     * Step 2
     */
    #[Session]
    public bool $is_inbound = true;

    #[Session]
    public TourPaymentType $payment_type = TourPaymentType::FULL;

    #[Session]
    public ?int $origin_id = null;

    #[Session]
    public string $description = '';

    #[Session]
    public string $return_policy = '';

    #[Session]
    public string $required_documents = '';

    #[Session]
    public string $services = '';

    #[Session]
    public string $installment_policy = '';


    /**
     * Step 3
     */
    #[Session]
    public ?string $slug = '';

    #[Session]
    public ?Carbon $published_at;
}
