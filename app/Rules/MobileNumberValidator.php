<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MobileNumberValidator implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^[6-9]\d{9}$/', $value);
    }

    public function message()
    {
        return 'Number must start with a digit between 6 and 9 and have a total of 10 digits.';
    }
    public function store(Request $request)
{
    $request->validate([
        'mobile1' => ['required','unique:tbl_hlclients', new MobileNumberValidator],
    ],
     [
        'mobile1.required'=>'Please Enter Your Mobile Number',
        'mobile1.unique'=>'The mobile number has already been taken.',
     ]);
    
}

}
