<?php

namespace App\Exports;

use App\Models\Subscriber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriberExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return $subscriber = Subscriber::all();
    }

    public function headings(): array
    {
        return [
            'subscriber_email',
            'status',
            'Created At',
        ];
    }
    public function map($subscriber): array
    {
        return [
            $subscriber->subscriber_email,
            $subscriber->status,
            $subscriber->created_at,
        ];
    }
}
