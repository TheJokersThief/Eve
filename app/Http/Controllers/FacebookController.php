<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Facebook;
use Redirect;
use Session;
use Auth;
use App\User;

class FacebookController extends Controller
{
	/**
	 * Callback to log in users from Facebook. Be warned; it's messy.
	 */
	public function authenticateFromJavascript(){
		try {
			$token = Facebook::getJavaScriptHelper()->getAccessToken();
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			// Failed to obtain access token
			return Redirect::to('/login')->withErrors([$e->getMessage()]);
		}
		if(!$token){
			return Redirect::to('/login')->withErrors(["You haven't logged into Facebook correctly."]);
		}

		if (! $token->isLongLived()) {
			// OAuth 2.0 client handler
			$oauth_client = Facebook::getOAuth2Client();

			// Extend the access token.
			try {
				$token = $oauth_client->getLongLivedAccessToken($token);
			} catch (Facebook\Exceptions\FacebookSDKException $e) {
				return Redirect::to('/login')->withErrors([$e->getMessage()]);
			}
		}

		Session::put('fb_user_access_token', (string) $token);
		Facebook::setDefaultAccessToken($token);

		try {
			$response = Facebook::get('/me?fields=id,name,email,bio,picture,location');
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			dd($e->getMessage());
		}

		$facebook_user = $response->getGraphUser();

		$user = User::createOrUpdateGraphNode($facebook_user);

		// Log the user into Laravel
		Auth::login($user);

		return Redirect::back();
	}
}
