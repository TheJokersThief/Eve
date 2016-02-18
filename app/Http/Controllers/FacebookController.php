<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Session;
use Auth;
use URL;
use App\User;
use Facebook;
use SammyK\LaravelFacebookSdk;

class FacebookController extends Controller
{
	/**
	 * Callback to log in users from Facebook. Be warned; it's messy.
	 */
	public function authenticateFromJavascript(Request $request, LaravelFacebookSdk\LaravelFacebookSdk $fb){

		// Try to grab the Facebook API token that the SDK should give us
		try {
			$token = $fb->getJavaScriptHelper()->getAccessToken();
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			// Failed to obtain access token; error out
			return Redirect::to('/login')->withErrors([$e->getMessage()]);
		}
		if(!$token){
			// If the token is falsy... uhh, what the hell
			return Redirect::to('/login')->withErrors(["You haven't logged into Facebook correctly."]);
		}

		if (! $token->isLongLived()) {
			// OAuth 2.0 client handler. This is... a thing.
			$oauth_client = $fb->getOAuth2Client();

			// Extend the access token.
			try {
				$token = $oauth_client->getLongLivedAccessToken($token);
			} catch (Facebook\Exceptions\FacebookSDKException $e) {
				return Redirect::to('/login')->withErrors([$e->getMessage()]);
			}
		}

		// Keep the User Access Token in Session storage, so we can use it for this request
		$data = $request->all();

		Session::put('fb_user_access_token', (string) $token);
		if(isset($data["from"])){
			Session::put('fb_logged_in_from', (string) $data["from"]);
		}


		// Use the user's access token by default for this request
		$fb->setDefaultAccessToken($token);

		try {
			// Request Facebook user data
			$response = $fb->get('/me?fields=id,name,email,location,bio,picture.width(800).height(800)');
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			return Redirect::back()->withErrors([$e->getMessage()]);
		}

		// get a Graph User object
		$facebook_user = $response->getGraphUser();


		// Use the Graph User to create a Laravel User with their data
		$user = User::createOrUpdateGraphNode($facebook_user);

		Auth::login($user);

		if(!$user->username){
			return Redirect::to('/user/editProfile')->with('message', 'Almost set up! Please fill out your profile...');
		}

		// Log the user into Laravel

		return Redirect::back();
	}
}
