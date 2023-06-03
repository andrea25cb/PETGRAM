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
use Laravel\Socialite\Two\InvalidStateException;

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
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $e) {
            // Manejar la excepción
            return redirect()->route('login-google')->with('error', 'Error al autenticar con Google.');
        }
    
        // Verificar si el usuario ya existe en la base de datos
        $user = User::where('external_id', $googleUser->id)->first();
    
        if ($user) {
            // Si el usuario existe, inicia sesión
            Auth::login($user);
        } else {
            // Si el usuario no existe, crea un nuevo usuario en la base de datos
            $user = User::create([
                'external_id' => $googleUser->id,
                'name' => $googleUser->name,
                'username' => $googleUser->email,
                'email' => $googleUser->email,
                'profile_image' => $googleUser->avatar_original,
                'password' => encrypt('gitpwd059'),
                'external_auth' => 'google',
            ]);
    
            // Inicia sesión con el nuevo usuario
            Auth::login($user);
        }
    
        return redirect('/');
    }
}