<?php
      /** 
* @file GoogleSocialiteController.php
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
class GoogleSocialiteController extends Controller
{
    
    /**
    * Redirects the user to the Google login page. This method is used by [[ LoginController ]] to redirect the user to the Google login page.
    * 
    * 
    * @return the RedirectResponse object to be used by [[ LoginController ]] to redirect the user to the Google login page
    */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect()->name('login-google');
    }

    /**
    * Handles the callback from Google. This is called when user clicks on the callback link. It logs the user in and redirects to the home page.
    * 
    * 
    * @return Response to the callback request. True if successful false otherwise and error message contains the error message to display
    */
    public function handleCallback()
    {  
        $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate([
                'external_id' => $googleUser->id,
            ], [
                'name' => $googleUser->name,
                'username' => $googleUser->email,
                'email' => $googleUser->email,
                'avatar' => $googleUser->avatar,
                'password' => encrypt('gitpwd059'),
                'external_id' => $googleUser->id,
                'external_auth' => 'google', //provider
            ]);
         
            // if (!$user->tlf) {
            //     return redirect()->route('completar-registro');
            // }
            Auth::login($user);
    
            return redirect('/');
}
}