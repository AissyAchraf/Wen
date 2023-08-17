<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class MultipleOf12 implements Rule
{
    public function passes($attribute, $value)
    {
        // Get the checkinDate from the request
        $checkinDate = Carbon::parse(request()->input('checkinDate'));
        
        // Get the checkoutDate
        $checkoutDate = Carbon::parse($value);
        
        // Calculate the time difference in hours
        $timeDifferenceHours = $checkoutDate->diffInHours($checkinDate);
        
        // Check if the time difference is a multiple of 12
        return $timeDifferenceHours % 12 === 0;
    }

    public function message()
    {
        return 'The time interval must be a multiple of 12 hours.';
    }
}
