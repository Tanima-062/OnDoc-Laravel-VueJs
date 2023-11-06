<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangeLanguage extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'language_id' => 'required|in:1,2,3,4'
        ]);
        $user = auth()->user();
        $user->update(['language_id' => $request->language_id]);
        return ['status' => 'success'];
    }
}
