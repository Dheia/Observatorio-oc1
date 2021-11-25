var num_respuestas=0;
var id_respuesta_actual=0;
var preguntas_evaluado = [];
var preguntas_evaluador = [];
var preguntas = [];

var get_preguntas_evaluado = $('#get_preguntas_evaluado').html();
var get_preguntas_evaluador = $('#get_preguntas_evaluador').html();

if( get_preguntas_evaluado !== undefined )  preguntas_evaluado = JSON.parse(get_preguntas_evaluado);
if( get_preguntas_evaluador !== undefined )  preguntas_evaluador = JSON.parse(get_preguntas_evaluador);

function eliminarRespuesta(id_respuesta, index_respuesta, txt_no_resp)
{
  $('#'+id_respuesta+index_respuesta).remove();
  if(num_respuestas>0) num_respuestas--;
  if(num_respuestas == 0) $('#'+txt_no_resp).text("No hay ninguna respuesta añadida...");
}

function resetPregunta()
{
  num_respuestas=0;
  id_respuesta_actual=0;
  $('#btns_cuestionario_1-1, #btns_cuestionario_2-1').removeClass("hidden");
  $('#btns_cuestionario_1-2, #block_resp, #block_preg, #btns_cuestionario_2-2, #block_resp2, #block_preg2').addClass("hidden");
  $('#Form-field-Evaluacion-text_respuesta, #add_pregunta_evaluado, #Form-field-Evaluacion-text_respuesta2, #add_pregunta_evaluador').removeClass("is-required");
  $('#text_respuesta, #text_pregunta, #text_respuesta2, #text_pregunta2').val("");
  $('#tipo-respuesta, #tipo-respuesta2').prop('selectedIndex',0);
  $('#txt_no_resp, #txt_no_resp2').text("No hay ninguna respuesta añadida...");
  $('#respuestas, #respuestas2').empty();
  $('#list_preguntas, #list_preguntas2').removeClass('hidden');
}

function getTipoRespuesta(pregunta)
{
  switch (pregunta) {
    case "1":
      return "Texto";
    case "2":
      return "Select";
    case "3":
      return "Radio";
    case "4":
      return "CheckBox";
    default:
      return "-";
  }
}

function eliminarPregunta(id_pregunta, index_preg , id_list)
{
  $('#'+id_pregunta+index_preg).remove();
  preguntas.splice(index_preg, 1);
  if( preguntas.length < 1 ) $('#'+id_list).addClass('hidden');
}

function mostrarPreguntas(id_pregunta, id_list)
{
  var p = '<br/><div class="control-list"><table class="table data"><thead><tr><th class="sort-desc text-center"><a href="/">Pregunta</a></th><th class="text-center"><a href="/">Tipo Respuesta</a></th><th class="text-center"><span>Nº Respuestas</span></th><th class="list-setup text-center"><a href="/" title="Opciones"></a></th></tr></thead><tbody>';

  preguntas.forEach(function(element, index) {
    p += '<tr id="'+id_pregunta+index+'"><td>'+element['pregunta']+'</td><td class="text-center">'+getTipoRespuesta(element['tipoRespuesta'])+'</td><td class="text-center">'+ (( element['respuestas'] ) ? element['respuestas'].length : '-' )  +'</td><td class="text-center" onclick="eliminarPregunta(\''+id_pregunta+'\','+index+',\''+id_list+'\')" style="cursor: pointer;"><i class="icon-trash-o trash"></i></td></tr>'
  });
  p += '</tbody></table></div>';
  if( preguntas.length > 0 ) $('#'+id_list).html(p);
  else $('#'+id_list).html("");
}


  $(document).ready(function() {
      $('#evaluadores_list').multiselect();

      // CUESTIONARIO EVALUADO
      $('#btn_add_pregunta_evaluado').on('click', function() {
          $('#block_preg, #btns_cuestionario_1-2').removeClass("hidden");
          $('#btns_cuestionario_1-1, #list_preguntas').addClass("hidden");
      });

      $('#btn_text_respuesta').on('click', function() {
        if($('#text_respuesta').val() != "")
        {
          if(num_respuestas==0) $('#txt_no_resp').text("");
          var id_respuesta = "respuesta";
          var respuesta='<div class="row" id="'+id_respuesta+id_respuesta_actual+'"><div onclick="eliminarRespuesta(\''+id_respuesta+'\','+id_respuesta_actual+',\'txt_no_resp\')" style="cursor: pointer; display: inline;" class="col-xs-1 trash"><i class="icon-trash-o"></i></div><div class="col-xs-11"><li>'+$('#text_respuesta').val()+'</li></div></div>';
          $('#respuestas').append(respuesta);
          $('#text_respuesta').val("");
          $('#Form-field-Evaluacion-text_respuesta').removeClass("is-required");
          num_respuestas++;
          id_respuesta_actual++;
        }
        else
        {
          $('#Form-field-Evaluacion-text_respuesta').addClass("is-required");
        }

      });

      $('#tipo-respuesta').on('change',function(){
        if($(this).val()==1) $('#block_resp').addClass("hidden");
        else $('#block_resp').removeClass("hidden");
      });

      $('#btn_cancel_preg').on('click',function(){
        resetPregunta();
      });

      $('#btn_save_preg').on('click',function(){
        var pregunta;

        if( $('#text_pregunta').val() == "" )
        {
          $('#add_pregunta_evaluado').addClass("is-required");
        }
        else
        {
          pregunta = {
            pregunta: $('#text_pregunta').val(),
            tipoRespuesta: $('#tipo-respuesta').val()
          };

          if( pregunta['tipoRespuesta'] != 1 )
          {
            var respuestas=[];
            $('#respuestas li').each( function() {
                  respuestas.push( $(this).html() );
            });

            if( respuestas.length < 1 ) {
              $('#Form-field-Evaluacion-text_respuesta').addClass("is-required");
              alert("No has añadido ninguna respuesta");
            }
            else {
              pregunta['respuestas'] = JSON.parse(JSON.stringify(respuestas));
              resetPregunta();
            }
          }
          else {
            // tipo respuesta TEXTo
            resetPregunta();
          }

          preguntas.push(pregunta);
          mostrarPreguntas("preguntas", "list_preguntas");
        }
      });


      $('#btn_cuestionario_1-1_guardar').on('click', function() {
          preguntas_evaluado = JSON.parse(JSON.stringify(preguntas));
          preguntas = [];
          if(preguntas_evaluado.length == 0) $('#btn_cuestionario_evaluado').text("Crear Cuestionario");
          else $('#btn_cuestionario_evaluado').text("Modificar Cuestionario");
      });

      $('#btn_cuestionario_1-1_descartar').on('click', function() {
          preguntas = [];
      });

      $('#btn_cuestionario_evaluado').on('click', function() {
          preguntas = JSON.parse(JSON.stringify(preguntas_evaluado));
          mostrarPreguntas("preguntas", "list_preguntas");
      });


      // CUESTIONARIO EVALUADOR
      $('#btn_add_pregunta_evaluador').on('click', function() {
          $('#block_preg2, #btns_cuestionario_2-2').removeClass("hidden");
          $('#btns_cuestionario_2-1, #list_preguntas2').addClass("hidden");
      });

      $('#btn_text_respuesta2').on('click', function() {
        if($('#text_respuesta2').val() != "")
        {
          if(num_respuestas==0) $('#txt_no_resp2').text("");
          var id_respuesta = "respuesta2";
          var respuesta='<div class="row" id="'+id_respuesta+id_respuesta_actual+'"><div onclick="eliminarRespuesta(\''+id_respuesta+'\','+id_respuesta_actual+',\'txt_no_resp2\')" style="cursor: pointer; display: inline;" class="col-xs-1 trash"><i class="icon-trash-o"></i></div><div class="col-xs-11"><li>'+$('#text_respuesta2').val()+'</li></div></div>';
          $('#respuestas2').append(respuesta);
          $('#text_respuesta2').val("");
          $('#Form-field-Evaluacion-text_respuesta2').removeClass("is-required");
          num_respuestas++;
          id_respuesta_actual++;
        }
        else
        {
          $('#Form-field-Evaluacion-text_respuesta2').addClass("is-required");
        }

      });

      $('#tipo-respuesta2').on('change',function(){
        if($(this).val()==1) $('#block_resp2').addClass("hidden");
        else $('#block_resp2').removeClass("hidden");
      });

      $('#btn_cancel_preg2').on('click',function(){
        resetPregunta();
      });

      $('#btn_save_preg2').on('click',function(){
        var pregunta;

        if( $('#text_pregunta2').val() == "" )
        {
          $('#add_pregunta_evaluador').addClass("is-required");
        }
        else
        {
          pregunta = {
            pregunta: $('#text_pregunta2').val(),
            tipoRespuesta: $('#tipo-respuesta2').val()
          };

          if( pregunta['tipoRespuesta'] != 1 )
          {
            var respuestas=[];
            $('#respuestas2 li').each( function() {
                  respuestas.push( $(this).html() );
            });

            if( respuestas.length < 1 ) {
              $('#Form-field-Evaluacion-text_respuesta2').addClass("is-required");
              alert("No has añadido ninguna respuesta");
            }
            else {
              pregunta['respuestas'] = JSON.parse(JSON.stringify(respuestas));
              resetPregunta();
            }
          }
          else {
            // tipo respuesta TEXTo
            resetPregunta();
          }

          preguntas.push(pregunta);
          mostrarPreguntas("preguntas2", "list_preguntas2");
        }
      });


      $('#btn_cuestionario_2-1_guardar').on('click', function() {
          preguntas_evaluador = JSON.parse(JSON.stringify(preguntas));
          preguntas = [];
          if(preguntas_evaluador.length == 0) $('#btn_cuestionario_evaluador').text("Crear Cuestionario");
          else $('#btn_cuestionario_evaluador').text("Modificar Cuestionario");
      });

      $('#btn_cuestionario_2-1_descartar').on('click', function() {
          preguntas = [];
      });

      $('#btn_cuestionario_evaluador').on('click', function() {
          preguntas = JSON.parse(JSON.stringify(preguntas_evaluador));
          mostrarPreguntas("preguntas2", "list_preguntas2");
      });

      $('#btn_create_eval').on('click', function() {
          var ok = true;
          var list_incluidos=[];
          var proyecto_id = $('#proyecto_id').val();
          var evaluado_id = $('#Form-field-Evaluacion-evaluado').val();

          if(evaluado_id == null) {
            $('#Form-field-Evaluacion-text1-group').addClass('is-required');
            alert('Debe seleccionar un Evaluado');

            ok = false;
          }
          else {
            $('#Form-field-Evaluacion-text1-group').removeClass('is-required');
          }

          if( ok && preguntas_evaluado.length === 0 )
          {
            $('#form_cuestionario_evaluado').addClass('is-required');
            alert('Debe añadir un cuestionario para el Evaluado');
            ok = false;
          }
          else {
            $('#form_cuestionario_evaluado').removeClass('is-required');
          }

          if( ok && preguntas_evaluador.length === 0 )
          {
            $('#form_cuestionario_evaluador').addClass('is-required');
            alert('Debe añadir un cuestionario para los Evaluadores');
            ok = false;
          }
          else {
            $('#form_cuestionario_evaluador').removeClass('is-required');
          }


          if(ok) {
            $('select#evaluadores_list_to option').each(function(i, sel){
              list_incluidos.push( $(sel).val() );
            });
            $.request("onSaveEval", {
              data:
                {
                  proyecto_id,
                  evaluado_id,
                  list_incluidos,
                  preguntas_evaluado: JSON.stringify(preguntas_evaluado),
                  preguntas_evaluador: JSON.stringify(preguntas_evaluador)
                }
            });
          }
      });

      $('#btn_edit_eval').on('click', function() {
        var ok = true;
        var list_incluidos=[];
        var proyecto_id = $('#proyecto_id').val();
        var evaluado_id = $('#Form-field-Evaluacion-evaluado').val();

        if(evaluado_id == null) {
          $('#Form-field-Evaluacion-text1-group').addClass('is-required');
          alert('Debe seleccionar un Evaluado');

          ok = false;
        }
        else {
          $('#Form-field-Evaluacion-text1-group').removeClass('is-required');
        }

        if( ok && preguntas_evaluado.length === 0 )
        {
          $('#form_cuestionario_evaluado').addClass('is-required');
          alert('Debe añadir un cuestionario para el Evaluado');
          ok = false;
        }
        else {
          $('#form_cuestionario_evaluado').removeClass('is-required');
        }

        if( ok && preguntas_evaluador.length === 0 )
        {
          $('#form_cuestionario_evaluador').addClass('is-required');
          alert('Debe añadir un cuestionario para los Evaluadores');
          ok = false;
        }
        else {
          $('#form_cuestionario_evaluador').removeClass('is-required');
        }


        if(ok) {
          $('select#evaluadores_list_to option').each(function(i, sel){
            list_incluidos.push( $(sel).val() );
          });
          $.request("onEditEval", {
            data:
              {
                proyecto_id,
                evaluado_id,
                list_incluidos,
                preguntas_evaluado: JSON.stringify(preguntas_evaluado),
                preguntas_evaluador: JSON.stringify(preguntas_evaluador)
              }
          });
        }
    });

      


  });
