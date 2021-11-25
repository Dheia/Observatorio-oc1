<?php namespace Tresfera\Talentapp\Traits;


trait TraitEvaluacion
{

    public function generaPass($longitudPass = 10)
    {
        $cadena = "AzByCxDwEvFuGtHsIrJqKpLoMnNmOlPkQjRiShTgUfVeWdXcYbZ1234567890!";
        $longitudCadena=strlen($cadena);
    
        $pass = "";
        
        for($i=1 ; $i<=$longitudPass ; $i++){
            $pos=rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }

    public function proyectoFinalizado()
    {
      return ( isset($this->proyecto) && $this->proyecto->finalizado() );
    }

    public function afterFetch() { $this->name = htmlspecialchars($this->name); } // str_replace("&quot;", '"', $this->name)

}