<?php namespace Tresfera\Envios\Models;

use Model;
use Tresfera\Envios\Models\Dato;
use Taket\Structure\Models\Question as Segmentacion;
use Taket\Structure\Models\Option as SegmentacionValue;
use Taket\Creator\Models\Quiz;
/**
 * Model
 */
class Envio extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at','send_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_envios_envio';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    public $hasMany = [
        'datos' => 'Tresfera\Envios\Models\Dato',
        'sends' => ['Tresfera\Envios\Models\Dato', 'scope' => 'isSend'],
        'opened' => ['Tresfera\Envios\Models\Dato', 'scope' => 'isOpen'],
        'completed' => ['Tresfera\Envios\Models\Dato', 'scope' => 'isCompleted'],
    ];
    public $attachOne = [
        'import_file' => 'System\Models\File'
    ];
    public function getQuizIdOptions() {
        return Quiz::all()->lists("name","id");
    }
    public function beforeDelete() {
        foreach($this->hasMany as $relation=>$params) {
            $this->$relation()->delete();
        }
    }
    public function afterSave() {
    }
    public function import() {
        if($this->import_file) {
            $path = $this->import_file->getLocalPath();
            $fila = 0;
            if (($gestor = fopen($path, "r")) !== FALSE) {
                while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
                    $numero = count($datos);
                    $fila++;
                    if($fila == 1) continue;
                    $dato = Dato::where("id_usuari",$datos[1])->where("envio_id",$this->id)->first();
                    if(!isset($dato->id))
                        $dato = new Dato();

                    $dato->club = $datos[0];
                    $this->insertSegmentacion("club",$datos[0]);
                    $dato->id_usuari = $datos[1];
                    $this->insertSegmentacion("id_usuari",$datos[1]);
                    $dato->es_home = $datos[2];
                    $this->insertSegmentacion("es_home",$datos[2]);
                    $dato->edat = $datos[3];
                    $this->insertSegmentacion("edat",$datos[3]);
                    $dato->antiguetat = $datos[4];
                    $this->insertSegmentacion("antiguetat",$datos[4]);
                    $dato->servei = $datos[5];
                    $this->insertSegmentacion("servei",$datos[5]);
                    $dato->es_familiar = $datos[6];
                    $this->insertSegmentacion("es_familiar",$datos[6]);
                    $dato->es_quota_parcial = $datos[7];
                    $this->insertSegmentacion("es_quota_parcial",$datos[7]);
                    $dato->accessos_mes = $datos[8];
                    $this->insertSegmentacion("accessos_mes",$datos[8]);
                    $dato->email = $datos[9];
                    $this->insertSegmentacion("email",$datos[9]);
                    $dato->mobil = $datos[10];
                    $this->insertSegmentacion("mobil",$datos[10]);
                    $dato->nom = $datos[11];
                    $this->insertSegmentacion("nom",$datos[11]);
                    $dato->enviar_at = $this->send_at;
                    $dato->envio_id = $this->id;
                    $dato->save();
                }
                fclose($gestor);
            }
        }
    }
    private function insertSegmentacion($name,$value) {
        $segmentacion = Segmentacion::where("slug",($name))->first();
        if(!isset($segmentacion->id)) {
            $segmentacion = new Segmentacion();
            $segmentacion->name  = $name;
            $segmentacion->slug  = $name;
            $segmentacion->title = $name;
            $segmentacion->is_filter = 1;
            $segmentacion->save();
        }
        try {
            $segmentacion_value = SegmentacionValue::where("question_id",$segmentacion->id)
                                                    ->where("value",$value)
                                                    ->first();
            if(!isset($segmentacion_value->id)) {
                $segmentacion_value = new SegmentacionValue();
                $segmentacion_value->question_id = $segmentacion->id;
                $segmentacion_value->value = $value;
                $segmentacion_value->title_stats = $value;
                $segmentacion_value->save();
            }
        } catch(\Exception $ex) {
            echo $name."\n";
            echo $ex->getMessage()."\n";
        }
    }
}
