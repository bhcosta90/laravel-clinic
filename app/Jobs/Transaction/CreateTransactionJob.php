<?php

declare(strict_types = 1);

namespace App\Jobs\Transaction;

use App\Enums\Models\Transaction\Type;
use App\Enums\Queue\Queue;
use App\Services\TransactionService;
use DateTimeInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CreateTransactionJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $name,
        public ?string $user_id,
        public ?int $agreement_id,
        public ?int $customer_id,
        public ?int $payment_method_id,
        public float $value,
        public ?string $description,
        public DateTimeInterface $due_date,
        public ?DateTimeInterface $payment_date,
        public Type $type,
        public ?Model $model = null,
    ) {
        $this->onQueue(Queue::Low);
    }

    public function handle(): void
    {
        $data = [
            'name'              => $this->name,
            'user_id'           => $this->user_id,
            'agreement_id'      => $this->agreement_id,
            'customer_id'       => $this->customer_id,
            'payment_method_id' => $this->payment_method_id,
            'value'             => $this->value,
            'description'       => $this->description,
            'due_date'          => $this->due_date,
            'payment_date'      => $this->payment_date,
            'type'              => $this->type,
        ];

        if ($this->model instanceof Model) {
            /** @var Model $class */
            $class = app($this->model::class);

            $data['model_type'] = $class->getMorphClass();
            $data['model_id']   = $this->model->getKey();
        }

        app(TransactionService::class)->handle('store', $data);
    }
}
