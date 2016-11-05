<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Socialite;
use App\User;
use Image;
use Storage;

class SocialAuthController extends Controller
{
    public function redirectToFacebook()
    {
    	 return Socialite::driver('facebook')->redirect();
    }

    public function returnFromFacebook()
    {
 		$fb_user = Socialite::driver('facebook')->user();
 		$user['social_id'] = $fb_user->user['id'];
 		$user['name'] = $fb_user->user['name'];
 		$user['email'] = $fb_user->user['email'];
 		$user['gender'] = $fb_user->user['gender'];
 		$user['avatar'] = $fb_user->avatar_original;
        $user['registration_type'] = 'facebook';
        $user['deleted_at'] = NULL;
 		dd($user);
    }

    public function redirectToTwitter()
    {
    	 return Socialite::driver('twitter')->redirect();
    }

    public function returnFromTwitter()
    {
		$twitter_user = Socialite::driver('twitter')->user();
		dd($twitter_user);
    }

    public function redirectToGoogle()
    {
    	 return Socialite::driver('google')->redirect();
    }

    public function returnFromGoogle()
    {
		$google_user = Socialite::driver('google')->user();
		dd($google_user);
    }

    public function redirectToLinkedin()
    {
    	 return Socialite::driver('linkedin')->redirect();
    }

    public function returnFromLinkedin()
    {
		$linkedin_user = Socialite::driver('linkedin')->user();
		dd($linkedin_user);
    }

    public function redirectToGithub()
    {
    	 return Socialite::driver('github')->redirect();
    }

    public function returnFromGithub()
    {
    	$github_user = Socialite::driver('github')->user();

        dd($this->fetchSocialImage($github_user->user['avatar_url']));

    	$user['social_id'] = $github_user->user['id'];
 		$user['name'] = $github_user->user['name'];
 		$user['email'] = $github_user->user['email'];
 		$user['avatar'] = $github_user->user['avatar_url'];
        $user['registration_type'] = 'github';
        $user['deleted_at'] = NULL;

        $userId = $this->createUserFromSocialMdia($user);
    }

    public function redirectToBitbucket()
    {
    	$bitbucket_user = Socialite::driver('bitbucket')->redirect();
        
        dd($this->fetchSocialImage($bitbucket_user->avatar));

        $user['id'] = $github_user->id;
        $user['username'] = $bitbucket_user->nickname;
        $user['name'] = $bitbucket_user->name;
        $user['email'] = $bitbucket_user->email;
        $user['avatar'] = $bitbucket_user->avatar;
        $user['registration_type'] = 'bitbucket';
        $user['deleted_at'] = NULL;

        $userId = $this->createUserFromSocialMdia($user);
    }

    public function returnFromBitbucket()
    {
    	$bitbucket_user = Socialite::driver('bitbucket')->user();
		dd($bitbucket_user);
    }

    public function createUserFromSocialMdia($user) 
    {

        $registration_type = NULL;
        $gender = NULL;

        dd(file_put_contents('110.png' , file_get_contents($user['avatar'])));


        $avatar_file = $user['avatar']->store($avatars_org_dir);
        
        $avatar_file_to_crop = ltrim($avatar_file, 'public/');
        $avatar_file_to_store = str_replace('origional', '300x600',$avatar_file_to_crop);

        Image::make($user['avatar'])->resize(300, 600)->save('storage/' . $avatar_file_to_store);

        switch($user['registration_type'])
        {
            case 'facebook':
                $registration_type = $user['registration_type'];
                $gender = $user['gender'];
            break;
            case 'twitter':    
                $registration_type = $user['registration_type'];
                break;
            case 'google':    
                $registration_type = $user['registration_type'];
                break;
            case 'linkedin':    
                $registration_type = $user['registration_type'];
                break;
            case 'github':    
                $registration_type = $user['registration_type'];
                break;
            case 'bitbucket':  
                $registration_type = $user['registration_type'];
                break;  
        }

        return User::create([
            'name' => $user['name'],
            'username' => NULL,
            'email' => $user['email'],
            'password' => NULL,
            'contact_no' => NULL,
            'gender' => $gender,
            'country' => NULL,
            'hobbies' => NULL,
            'about_me' => NULL,
            'date_of_birth' => NULL,
            'avatar' => $avatar_file_to_store,
            'user_type' => 'blogger',
            'social_id' => NULL,
            'registration_type' => registration_type,
            'deleted_at' => NULL
        ]);
    }

    public function fetchSocialImage($avatar_url)
    {
        $avatars_org_dir = 'public/avatars/origional';
        Storage::makeDirectory($avatars_org_dir);

        $avatars_upload = 'storage/avatars/origional/';

        $avatar_info = getimagesize($avatar_url);
        $extension = image_type_to_extension($avatar_info[2]);
        $avatar_file_name = rand() . $extension;

        if(file_put_contents($avatars_upload . $avatar_file_name, file_get_contents($avatar_url))) {
            return $avatar_file_name;
        }
        return false;
    }
}
