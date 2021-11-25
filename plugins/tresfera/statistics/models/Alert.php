<?php namespace Tresfera\Statistics\Models;

use Model;
use Mail;
use Tiipiik\SmsSender\Classes\Sender as SmsSender;
use System\Models\MailTemplate;
use BackendAuth;
use Tresfera\Clients\Models\Client;
/**
 * alert Model
 */
class Alert extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_statistics_alerts';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
	
    /**
     * @var array Fillable fields
     */
    protected $fillable = [];
    protected $jsonable = ['phones','emails'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
	
	
	public function beforeSave() {
		$user = BackendAuth::getUser();
		if(isset($user->id))
		$this->client_id = $user->client_id;
	}

	static function scanAlert($answer) {
		//Controlamos alertas
		//si es tipo NPS
		$client = Client::find($answer->result->client_id);
		if(!isset($client->id)) return;
	    try {
		    if($answer->question_type == 'nps') {

			    // comprobamos que el cliente tenga alertas:
			    // Tiene alertas negativas?
			    if($answer->value_type == 1) {
					if(isset($client->alerts->ko))
				    if($client->alerts->ko == 1) {
					    $client->alerts->ko_count++;
					    // si llega al máximo ejecutamos alerta
					    if($client->alerts->ko_count >= $client->alerts->ko_num) {

						    //Ejecutamos alerta
						    //echo "Envio de alerta de insatisfacción...";
						    $client->alerts->ko_count = 0;
						    
						    $data = [];
						    
							//Enviamos email
							$emails =  $client->alerts->emails;

							if(count($emails))
							Mail::send("alert_ko", $data, function($message) use ($emails)
							{
								$name = "";
								foreach($emails as $email) {
									$message->to($email['phone'], "");
								}
								
							});
						    
						    //Enviamos SMSs
						    if($client->alerts->ko_sms == 1) {
							    foreach($client->alerts->phones as $phone) {
								    SmsSender::sendMessage("34".$phone['phone'], 'Alerta de insatisfacción');
							    }							    
						    }
						    
						    
					    }
					    $client->alerts->save();
				    } 
			    } elseif($answer->value_type == 3) {
				    if(isset($client->alerts))
				    if($client->alerts->ok == 1) {
					    $client->alerts->ok_count++;
					    // si llega al máximo ejecutamos alerta
					    if($client->alerts->ok_count >= $client->alerts->ok_num) {
						    //Ejecutamos alerta
						    //echo "Envio de alerta de satisfacción...";
						    $client->alerts->ok_count = 0;
						    
						    $data = [];
						    
							//Enviamos email
							Mail::send("alert_ok", $data, function($message)  use ($answer)
							{
								$name = "";
									$email = $client->email;
							    $message->to($email, $name);
							});
						    
						    //Enviamos SMSs
						    if($client->alerts->ko_sms == 1) {
							    foreach($client->alerts->phones as $phone) {
								    SmsSender::sendMessage("34".$phone['phone'], 'Alerta de satisfacción');
							    }							    
						    }
					    }
					    $client->alerts->save();
				    } 
				}   
			    
		    }
	    } catch(Exception $e){
		    
	    }
	}
}