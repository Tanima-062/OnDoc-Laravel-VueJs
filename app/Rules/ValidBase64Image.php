<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Intervention\Image\ImageManagerStatic;

class ValidBase64Image implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(public $types = null, public $size = null)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $image = ImageManagerStatic::make($value);

            if ($this->size && $this->size * 1000 < (int) strlen(rtrim($value, '=')) * 0.75) {
                $this->custom_message = "Image Size must be less then $this->size kb";
                return false;
            }

            if ($this->types && !in_array($image->mime(), $this->types)) {
                $this->custom_message = "Image types must be in " . implode(", ", $this->types);
                return false;
            }
            $image->destroy();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid image provided.';
    }
}
