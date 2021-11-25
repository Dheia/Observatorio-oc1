<?php

namespace Tresfera\Buildyouup\Classes\Http\Controllers;

use Illuminate\Routing\Controller;
use Tresfera\Buildyouup\Models\Slide as Model;

class Slide extends Controller
{
    /**
     * Render Slide.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $slide = Model::find($id);
		
        return $slide->render();
    }
}
