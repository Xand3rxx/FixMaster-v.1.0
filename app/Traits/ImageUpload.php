<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
// use Image;

trait ImageUpload
{
    /**
     * Does very basic image validity checking and stores it. Redirects back if an error occurs.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @param string directory
     * @return $this|false|string
     */
    public function verifyAndStoreImage(Request $request, string $imageDirectory, int $width, int $height)
    {

        if ($request->hasFile('image')) {

            //Validate image
            if (!$request->file('image')->isValid()) {

                return redirect()->back()->with('error', 'Invalid Image selected')->withInput();
            }

            //Get image file
            $image = $request->file('image');

            //Generate uuid as name appended to the image extension
            $imageName = (string) Str::uuid() . '.' . $image->getClientOriginalExtension();

            //Reduce image size and save to directory
            Image::make($image->getRealPath())->resize($width, $height)->save($imageDirectory . $imageName);

            //Return image name
            return $imageName;
        }

        return null;
    }

    public static function imageUploader(\Illuminate\Http\UploadedFile $image, string $directory, int $width = 500, int $height = 500)
    {
        if (!request()->file($image)) {
            request()->session()->flash('error', 'Invalid Image');
            return back()->withInput();
        }

        //Generate uuid as name appended to the image extension
        $imageName = (string) Str::uuid() . '.' . $image->getClientOriginalExtension();
        dd($imageName);
        //Reduce image size and save to directory
        Image::make($image->getRealPath())->resize($width, $height)->save($directory . $imageName);

        //Return image name
        return $imageName;

    }
}
