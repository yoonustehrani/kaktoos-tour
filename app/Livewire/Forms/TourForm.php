<?php

namespace App\Livewire\Forms;

use App\Enums\TourPaymentType;
use App\Models\Tour;
use App\Models\TourDestination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;
use Livewire\WithFileUploads;
use ReflectionObject;

class TourForm extends Form
{
    public ?Tour $tour;

    /**
     * Step 1
     */
    #[Session]
    public string $title = '';

    #[Session]
    public int $number_of_nights = 0;

    #[Session]
    public ?string $airline_code;

    #[Session]
    public string $image_src = '';
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

    /**
     * @return array Array of Validation rules for each step
     */
    public static function validation_rules()
    {
        return [
            1 => [
                'title' => 'required|string|min:3|max:120',
                'number_of_nights' => 'required|int|min:0|max:20',
                'airline_code' => 'required|string|min:2|max:3|exists:airlines,code',
                'image_src' => 'required|string'
            ],
            2 => [
                'is_inbound' => 'required|boolean',
                'payment_type' => ['required', Rule::enum(TourPaymentType::class)],
                'origin_id' => 'required|exists:locations,id',
                'description' => 'nullable|string|min:3|max:500',
                'return_policy' => 'nullable|string|min:3|max:500',
                'required_documents' => 'nullable|string|min:3|max:500',
                'services' => 'nullable|string|min:3|max:500',
                'installment_policy' => 'required_if:payment_type,I|string|min:3|max:500'
            ],

            3 => [
                'slug' => 'required|unique:tours,slug|string|min:2|max:150',
                'published_at' => 'required|after:now'
            ]
        ];
    }

    // public function tour()

    public function save()
    {
        $this->tour = new Tour();
        $this->tour->fill($this->except(['tour', 'description', 'return_policy', 'required_documents', 'services', 'installment_policy']));
        $this->tour->meta = $this->only(['description', 'return_policy', 'required_documents', 'services', 'installment_policy']);
        return $this->tour->save();
    }
}
