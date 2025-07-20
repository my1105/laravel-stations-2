<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie_id' => 'required|exists:movies,id',
            'start_time_date' => ['required', 'date_format:Y-m-d'],
            'start_time_time' => ['required', 'date_format:H:i'],
            'end_time_date' => ['required', 'date_format:Y-m-d'],
            'end_time_time' => ['required', 'date_format:H:i'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->start_time_date || !$this->start_time_time ||
                !$this->end_time_date || !$this->end_time_time) {
                return;
            }

            try {
                $startDateTime = $this->start_time_date . ' ' . $this->start_time_time;
                $endDateTime = $this->end_time_date . ' ' . $this->end_time_time;

                $start = Carbon::parse($startDateTime);
                $end = Carbon::parse($endDateTime);

                Log::info('Validation Debug:', [
                    'start' => $start->format('Y-m-d H:i'),
                    'end' => $end->format('Y-m-d H:i'),
                    'diff_minutes' => $start->diffInMinutes($end),
                    'start_less_than_end' => $start->lessThan($end),
                    'start_gte_end' => $start->greaterThanOrEqualTo($end)
                ]);

                if ($this->start_time_date !== $this->end_time_date) {
                    $startDate = Carbon::createFromFormat('Y-m-d', $this->start_time_date);
                    $endDate = Carbon::createFromFormat('Y-m-d', $this->end_time_date);

                    if ($startDate->greaterThan($endDate)) {
                        $validator->errors()->add('start_time_date', '開始時刻は終了時刻より前にしてください。');
                        $validator->errors()->add('end_time_date', '開始時刻は終了時刻より前にしてください。');
                        return;
                    }
                }

                if ($start->greaterThanOrEqualTo($end)) {
                    if ($this->start_time_date === $this->end_time_date) {
                        $validator->errors()->add('start_time_time', '開始時刻は終了時刻より前にしてください。');
                        $validator->errors()->add('end_time_time', '開始時刻は終了時刻より前にしてください。');
                    }
                    return;
                }

                $diffMinutes = $start->diffInMinutes($end);
                if ($diffMinutes <= 5) {
                    Log::info('Adding 5-minute validation error', ['diff' => $diffMinutes]);
                    $validator->errors()->add('start_time_time', '上映時間は5分以上にしてください。');
                    $validator->errors()->add('end_time_time', '上映時間は5分以上にしてください。');
                }
            } catch (\Exception $e) {
                Log::error('Validation Exception:', ['error' => $e->getMessage()]);
            }
        });
    }
}
