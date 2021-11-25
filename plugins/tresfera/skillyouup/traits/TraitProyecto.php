<?php namespace Tresfera\Skillyouup\Traits;


trait TraitProyecto 
{
    public function getClientIdOptions($keyValue = null)
    {
        $clients = \Tresfera\Clients\Models\Client::lists("name","id");
        return $clients;
    }

    public static function getCurrentFilters($lista = null) {
        $filters = [];
        foreach (\Session::get('widget', []) as $name => $item) 
        {
          if (str_contains($name, 'Filter')) {
              $filter = @unserialize(@base64_decode($item));
              if ($filter) {
                  $filters[$name][] = $filter;
              }
          }
        }
        if(!$lista) return $filters;
        else if(isset($filters[$lista])) return $filters[$lista];
        return [];
    }



    public function finalizado()
    {
        return ( $this->fecha_fin <= \Carbon\Carbon::now() );
    }

    public function afterFetch() { $this->name = htmlspecialchars($this->name); } // str_replace("&quot;", '"', $this->name)

}