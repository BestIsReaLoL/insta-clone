<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $query = Profile::whereHas('user');

        if ($request->has('q')) {
            $query->where('username', 'like', '%' . $request->q . '%');
        }

        $query->with('user', 'followers');

        return view('profiles.index', [
            'profiles' => $query->paginate(Profile::PAGINATE_COUNT),
            'query' => $request->q
        ]);
    }

    public function show(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postCount = $user->posts->count();

        $followersCount = $user->profile->followers->count();

        $followingCount = $user->following->count();

        return view('profiles.show', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user->profile);

        $data = $request->validate([
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        if ($request->image) {
            $imageTempPath = $request->image->store('profile');
            $imagePath = Storage::url($imageTempPath);

//            $image = Image::make(public_path("/storage/{$imagePath}"))->fit(1080, 1080, function ($constraint) {
//                $constraint->upsize();
//            });

//            $imagePath = Cloudinary::upload($request->file('image')->getRealPath(), [
//                'folder' => 'laragram/avatar',
//                'transformation' => [
//                    'background' => 'white',
//                    'width' => 400,
//                    'height' => 400,
//                    'crop' => 'pad'
//                ]
//            ])->getSecurePath();

//            $oldProfileImage = public_path($user->profile->image);

//            $image->save();

            $imageArray = ['image' => $imagePath];

//            if (file_exists($oldProfileImage)) {
//                @unlink($oldProfileImage);
//            }
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect()->route('profiles.show', $user);
    }

    public function followings($username)
    {
        $profiles = User::where('username', $username)
            ->first()
            ->following()
            ->paginate(Profile::PAGINATE_COUNT);

        return view('profiles.followings', compact('profiles'));
    }

    public function followers($username)
    {
        $users = User::where('username', $username)
            ->first()
            ->profile
            ->followers()
            ->with('profile')
            ->paginate(User::PAGINATE_COUNT);

        return view('profiles.followers', compact('users'));
    }
}
