<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Models\Aplicativos\User;
use App\Models\bd_proveedores\Usuario;
use App\Models\bd_proveedores\ContactoProveedor;
use App\Models\Aplicativos\LogUsuario;
use App\Models\Genericas\TDirNacional;
use App\Models\Genericas\TVendedor;
use App\Models\Genericas\Tercero;

use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    private $retuUserName = '';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginFormProv(){
        return view('auth.loginProv');
    }

    /**
     * Override the username method used to validate login
     *
     * @return string
     */
    public function username()
    {
        return $this->retuUserName;
    }

    /**
     * Override a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $data = $request->all();
        if (isset($request->all()['nit'])) {
            $this->retuUserName = 'usu_txt_usuario';
            // Consulto terceros
            $tercero = Tercero::where('idTercero', $data['nit'])->first();
            // Consulto los usuarios de proveedores
            $proveedores = Usuario::where([['usu_txt_usuario', $data['cedula']], ['usu_txt_clave', md5($data['password'])], ['usu_num_activo', 1]])->first();
            // Consulto contacto proveedores
            $contactoProveedor = ContactoProveedor::where([['con_num_documento', $data['cedula']], ['usu_id', $data['nit']]])->first();
            $errores = [];
            if ($tercero != null) {
                if ($proveedores == null) {
                    array_push($errores, 'Usuario o Contrase&ntilde;a son incorrectos, vuelva a intentarlo');
                }
                if($contactoProveedor == null){
                    array_push($errores, 'El proveedor con el nit '. $data['nit'] . ' no tiene ningun usuario asociado con la cedula '. $data['cedula']);
                }
            }else{
                array_push($errores, 'El nit '. $data['nit'] . ' no ha sido registrado como proveedor de la compañia');
            }

            if (count($errores) == 0) {
                Auth::loginUsingId($data['cedula'], false);
            }else{

            }
           

            return view('session')->with(['inputs' => []]);
        }else{
            $this->retuUserName = 'login';
            $this->validateLogin($request);

            $user = User::where([['login', 'LIKE BINARY', $request->login], 'password' => md5($request->password), 'numactivo' => '1'])->first();
            if(count($user) > 0){
                $dirnacional = TDirNacional::where('dir_txt_cedula', $user->idTerceroUsuario)
                                         ->first();

                Auth::loginUsingId($request->login, false);

                $time = time();
                Auth::user()->update(['fechaIngreso' => $time]);

                $vendedor = TVendedor::where('ven_id', $user->idTerceroUsuario)
                                   ->first();

                $info = [
                            'url' => env('APPV1_SESSION'),
                            'app' => 'aplicativos',
                            'idUsuario' => $user->login,
                            'idTercero' => $user->idTerceroUsuario,
                            'ultimoIngreso' => $time,
                            'cedula' => $user->idTerceroUsuario,
                            'nombreCompleto' => $user->nombre.' '.$user->apellido,
                            'correoElectronico' => $dirnacional ? $dirnacional->dir_txt_email : '',
                            'ven_id' => $vendedor ?  $vendedor->ven_id : ''
                        ];

                $log = new LogUsuario;
                $log->usu_id = $user->login;
                $log->log_num_creacion = $time;
                $log->log_txt_ip = $_SERVER['REMOTE_ADDR'];
                $log->log_txt_url = $_SERVER['REQUEST_URI'];
                $log->log_num_tipo = 1;

                $log->save();

              return view('session')->with(['inputs' => $info]);
            }

            $errors = ['login' => 'Usuario o Contrase&ntilde;a son incorrectos, vuelva a intentarlo'];

            return redirect()->back()
                             ->withErrors($errors);

        }
       
    }

    /**
     * Override Log the user out of the application.
     *
     * @return void
     */
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
