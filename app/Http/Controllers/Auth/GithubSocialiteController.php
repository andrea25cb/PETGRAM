<?php
   /** 
* @file GithubSocialiteController.php
* @author andrea cordon
* @date 28/02/2023
*/
namespace App\Http\Controllers\Auth;
   
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;   
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
class GithubSocialiteController extends Controller
{
    /**
    * Redirects the user to GitHub. This is a shortcut for ` driver ('github') - > redirect () `.
    * 
    * 
    * @return True if the user is redirected false otherwise. Note that this will return false if there is no user
    */
    public function gitRedirect()
    {
        return Socialite::driver('github')->redirect();
    }
       
    /**
    * Handles the callback from GitHub. This is called when the user logs in. It creates a user with the data we received from the GitHub API and logs them in.
    * 
    * 
    * @return Redirects to the home page after logging in the user is successful or an error message if there was a problem
    */
    public function handleCallback()
    {
        
        $githubUser = Socialite::driver('github')->user();
 
        $user = User::updateOrCreate([
            'external_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name,
            'username' => $githubUser->nickname,
            'email' => $githubUser->email,
            'avatar' => $githubUser->avatar,
            'password' => encrypt('gitpwd059'),
            'external_id' => $githubUser->id,
            'external_auth' => 'github', //provider
        ]);
     
        Auth::login($user);

        return redirect('/');
}
}