<?php namespace Tresfera\Taketsystem\Models;

use Model;
use Mail;
use Carbon\Carbon;
use Tiipiik\SmsSender\Classes\Sender as SmsSender;
use BackendAuth;
use Tresfera\Taketsystem\Models\Quiz;
/**
 * invitacion Model
 */
class Invitacion extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_invitaciones';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

	protected $statusLabel = [
		0 => 'Error',
		1 => 'Pendiente de envío',
		2 => 'Enviado',
		3 => 'Pendiente de contestar',
		4 => 'Contestado'
	];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'quiz' => ['Tresfera\Taketsystem\Models\Quiz'],	    
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
	
	
	public function beforeCreate() {
		$user = BackendAuth::getUser();
				
	    if ($user->client_id) {
		   $this->client_id = $user->client_id; 
		   $quiz = Quiz::where("client_id", "=", $this->client_id)->first();
		   $this->quiz_id = $quiz->id;
		}	
		$this->md5 = md5(rand().$this->quiz_id);
	}
	
	public function afterCreate(){
		$this->status = 1;

		if($this->salida_at) {
			$salida_at = Carbon::createFromFormat('Y-m-d', $this->salida_at);
			$this->envio_at = $salida_at->subDay(1);
			$this->save();
	    }
	    else {
			$this->envio_at = Carbon::now()->toDateTimeString();
			$this->send();
		}
		
	}
	
	public function send(){
		$url = "http://app.taket.es/?id=".$this->quiz->md5."&in=".$this->md5;
		
		
		$apiauth = "d16400c196fb7aa6a8c63f3584306d4aec4ecb49";
		$my_bitly = new \Hpatoio\Bitly\Client($apiauth);
		
		$response = $my_bitly->Shorten(array("longUrl" => $url));
		
		$shortUrl = $response['url'];
		
		if($this->email != '') {
			//Enviamos email
			$data['email'] = $this->email;
			
			Mail::send("invitacion", $data, function($message)
			{
			    $message->to($email);
			});
		}
		if($this->phone != '') {
			//Enviamos email
			$data  = [ 
				'text' => "Deseamos que haya estado a gusto con nosotros. Para seguir mejorando le agradeceremos nos deje su opinión.  Gracias y hasta pronto ".$shortUrl 
			];
			SmsSender::sendMessage("34".$this->phone, $data['text']);
			
		}
		$this->status = 2;
		$this->envio_at = Carbon::now()->toDateTimeString();
		$this->save();
	}
	
	public function getEstadoAttribute(){
		if($this->status)	
			return $this->statusLabel[$this->status];
	}
}