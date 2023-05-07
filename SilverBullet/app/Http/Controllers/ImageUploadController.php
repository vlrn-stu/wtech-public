<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();

        $request->image->move(public_path('uploads'), $imageName);

        // Return the relative path instead of the full URL
        $imageUrl = 'uploads/' . $imageName;

        $image_urls = Session::get('image_urls') ?? [];

        array_push($image_urls, $imageUrl);

        Session::put('image_urls', $image_urls);

        return back()
            ->with('success', 'Image uploaded successfully.')
            ->with('image_url', $imageUrl);
    }

    public function delete($imageUrl)
    {

        $relativeFilePath = str_replace(url('/'), '', $imageUrl);

        $absoluteFilePath = public_path($relativeFilePath);
        if (file_exists($absoluteFilePath)) {
            unlink($absoluteFilePath);
            return true;
        }

        return false;
    }



}
