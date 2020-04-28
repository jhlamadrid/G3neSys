<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert2/animate.css" >
<link rel="stylesheet" href="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert2/sweetalert2.min.css" >
<section class="content">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <strong><h3 class="text-success text-center">DENUNCIAS</h3></strong>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h4>Tiene x denuncias pendientes</h4>
          <span class="pull-right badge bg-green" style="margin-left:10px">Atendidos</span>&nbsp;&nbsp;
          <span class="pull-right badge bg-yellow" >Pendientes</span>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id='denuncias' class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                    <th>CÓDIGO</th>
                    <th>NOMBRE</th>
                    <th>DESCRIPCIÓN</th>
                    <th>FECHA</th>
                    <th>VISTA PREVIA</th>
                    <th>ESTADO</th>
                    <th>OPCIONES</th>
                </tr>
              </thead>
              <tbody style="    font-size: 1.2em;">
                <?php foreach ($denuncias as $denuncia) {?>

                    <tr style="<?php $valor =  (($denuncia['DENU_ESTADO'] == '0') ?  'background: #f39c12; color: #FFF' :  'background: #00a65a; color: #FFF');echo $valor; ?>">
                    <td><?php echo $denuncia['DENU_COD']?></td>
                    <td><?php echo $denuncia['DENU_NOM']?></td>
                    <td><?php echo $denuncia['DENU_DESC']?></td>
                    <td><?php echo $denuncia['FECHA']?></td>
                    <td style="text-align: center;"><img src="<?php echo $denuncia['DENU_IMAGEN']?>" width='50'/></td>
                    <td><?php if($denuncia['DENU_ESTADO'] == '0'){ echo "PENDIENTE";}else{echo "ATENDIDO";} ?></td>
                    <td style="text-align:center">
                      <a href="#" class="btn btn-default btn-flat" id ="<?php echo $denuncia['DENU_COD']; ?>" data-toggle="modal" data-target="#myModal7" title="Ver Denuncia"><i class="fa fa-eye"></i></a>
                      <?php if($denuncia['DENU_ESTADO'] == '0') { ?>
                        <a href="#" class="btn btn-default btn-flat"  title="Atencer Denuncia"><i class="fa fa-building"></i></a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal inmodal fade" id="myModal7" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md" style="width: 90% !important;">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Detalle de la Denuncia </h4>
            <span class="pull-right badge bg-red" id='fecha_denucia'></span>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6 col-md-6">
                  <img src="" id='img_denuncia' alt="" width="100%"><br><br>
                  <div class="input-group">
                    <div class="input-group-addon bg-green">Nombre</div>
                    <input type="text" class="form-control" id='nombre_imagen' id="exampleInputAmount" style="width:100%" disabled>
                  </div><br>
                  <textarea class="form-control" rows="3" id='descripcion_imagen' disabled></textarea><br>
                  <div class="input-group">
                    <div class="input-group-addon bg-green">Dirección (Aproximada)</div>
                    <input type="text" class="form-control" id='direccion_imagen' id="exampleInputAmount" style="width:100%" disabled>
                  </div><br>
                </div>
                <div class="col-sm-6 col-md-6">
                      <div id="map" style="height: 500px;"></div>
                </div>
              </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
          </div>
        </div>
    </div>
</div>

<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('ip'); ?>frontend/plugins/sweetalert2/sweetalert2.min.js" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyByK_KuQsvTctNIbgpscCtFsU-ji_lkDHk"></script>
<script>
  $('#denuncias').DataTable({ bInfo: false,"ordering": false,"lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]],});

</script>
<script>

function init(latitud,longitud,descripcion){
    //var address = 'Japan';
    var bangalore = { lat: parseFloat(latitud), lng: parseFloat(longitud)};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      center: {lat: parseFloat(latitud), lng: parseFloat(longitud)}
    });

    //objeto geocoder - reverse geocoding
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({'location': bangalore}, function(results, status) {
     if (status === google.maps.GeocoderStatus.OK) {
       if (results[1]) {
         console.log(results[1].formatted_address);
         $("#direccion_imagen").val(results[1].formatted_address)
       } else {
         console.log('No results found');
         $("#direccion_imagen").val("NO SE PUDO HALLAR")
       }
     } else {
       $("#direccion_imagen").val("HUBO UN ERROR CON GOOGLE MAPS")
       console.log('Geocoder failed due to: ' + status);
     }
   });
   //info window
    var contentString = '<div id="content">'+
     '<div id="siteNotice">'+
     '</div>'+
     '<h4 id="firstHeading" class="firstHeading">Detalle Denuncia</h4>'+
     '<div id="bodyContent">'+
     '<p>'+descripcion+'.</p>'+
     '</div>'+
     '</div>';

     var infowindow = new google.maps.InfoWindow({
       content: contentString
     });

     //marker
    var marker = new google.maps.Marker({
      position: bangalore,
      map: map,
      animation: google.maps.Animation.DROP,
      title: 'Hello World!'
    });

    marker.addListener('click', function() {
       infowindow.open(map, marker);
     });

     //circunferencia marker
     draw_circle = new google.maps.Circle({
                    center: marker.getPosition(),
                    radius: 250,
                    strokeColor: "#296fb7",
                    strokeOpacity: 0.6,
                    strokeWeight: 1,
                    fillColor: "#FF0000",
                    fillOpacity: 0.35,
                    map: map
                });
    }


$('#myModal7').on('shown.bs.modal', function(e){
  var button = e.relatedTarget;
  console.log(button.id)
  $.ajax({
    type:'POST',
    url : '<?php echo $this->config->item('ip'); ?>denuncias/get_denuncia?ajax=true',
    data: ({
      denuncia : button.id
    }),
    dataType: 'text',
    success: (data)=>{
      resultado = JSON.parse(data)
      if(resultado.result == true){
        $("#map").css("width",((window.innerWidth/2)-150)+ "px")
        $("#img_denuncia").attr('src',resultado.denuncia.DENU_IMAGEN)
        $("#nombre_imagen").val(resultado.denuncia.DENU_NOM);
        $("#descripcion_imagen").val(resultado.denuncia.DENU_DESC);
        $("#fecha_denucia").html(resultado.denuncia.FECHA)
        init(resultado.denuncia.DENU_LATITUD,resultado.denuncia.DENU_LOGITUD,resultado.denuncia.DENU_DESC);
      } else {
        swal({
            title: '',
            text: resultado.mensaje,
            timer: 2000
          }).then(
            function () {},
            // handling the promise rejection
            function (dismiss) {
              if (dismiss === 'timer') {
                console.log('I was closed by the timer')
              }
            }
          )
      }
    }, error: () => {
      $("#myModal7").modal('hide');
      swal({
        title: 'jQuery HTML example',
        html: $('<div>')
          .addClass('animated bounceOutLeft')
          .text('Ocurrió un problema con el Servidor...!'),
        animation: false,
        customClass: 'animated tada'
        })
    }
  })
   });

</script>
