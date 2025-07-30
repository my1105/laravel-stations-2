<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
                use App\Models\Schedule;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie_id' => ['required', 'exists:movies,id'],
            'screen_id' => ['required', 'exists:screens,id'],
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

            if ($start->greaterThanOrEqualTo($end)) {
                $validator->errors()->add('start_time_time', '開始時刻は終了時刻より前にしてください。');
                $validator->errors()->add('end_time_time', '開始時刻は終了時刻より前にしてください。');
                return;
            }

            if ($start->diffInMinutes($end) <= 5) {
                $validator->errors()->add('start_time_time', '上映時間は5分以上にしてください。');
                $validator->errors()->add('end_time_time', '上映時間は5分以上にしてください。');
                return;
            }

            // ✅ 重複チェック（ここが重要！）
            $exists = Schedule::where('screen_id', $this->screen_id)
                ->where(function ($query) use ($start, $end) {
                    $query->whereBetween('start_time', [$start, $end])
                          ->orWhereBetween('end_time', [$start, $end])
                          ->orWhere(function ($query) use ($start, $end) {
                              $query->where('start_time', '<=', $start)
                                    ->where('end_time', '>=', $end);
                          });
                })
                ->exists();

            if ($exists) {
                $validator->errors()->add('screen_id', 'このスクリーンではすでにその時間帯に上映が予定されています。');
            }

        } catch (\Exception $e) {
            Log::error('Validation Exception:', ['error' => $e->getMessage()]);
        }
    });
}
}