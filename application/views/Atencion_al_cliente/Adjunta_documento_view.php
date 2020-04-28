<link rel="stylesheet" href="./frontend/plugins/sweetalert/sweetalert2.css" type="text/css">
<script src="./frontend/plugins/sweetalert/sweetalert2.min.js"></script>
<section class="content">


            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 col-offset-1">
                    <div class="box box-warning">
                        
                        <div class="box-header with-border">
                            <h4 class="text-center"> ADJUNTAR SOLICITUD DE AFILIACIÓN Y DESAFILIACIÓN AL RECIBO DIGITAL POR CORREO ELECTRÓNICO</h4>
                        </div>
                       
                        <form method="post" action="<?php echo base_url().'Atencion_al_cliente/sub_arch' ?>"  class="form-horizontal" enctype="multipart/form-data">
                        <div class="box-body">
                             <?php if (isset($_SESSION['mensaje1']) || isset($_SESSION['mensaje2']) ){ ?>
                                    <?php if (isset($_SESSION['mensaje2'])){ ?>
                                             <br>
                                               <div class="row">
                                                   <div class="col-md-12">
                                                       <div class="col-md-12">
                                                           <div class="alert alert-success alert-dismissable">
                                                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                          <strong>Atención........</strong> El documento se ha agregado con exito.
                                                          </div>
                                                       </div>
                                                   </div>
                                               </div>
                                    <?php } if(isset($_SESSION['mensaje1'])) {?>
                                            <br>
                                               <div class="row">
                                                   <div class="col-md-12">
                                                       <div class="col-md-12">
                                                           <div class="alert alert-danger alert-dismissable">
                                                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                          <strong>Atención........</strong> Solo debe adjuntar archivos pdf.
                                                          </div>
                                                       </div>
                                                   </div>
                                              </div>
                                    <?php }?>
                             <?php } else {?>
                                     <?php if($estado_arch!='0'){ ?>
                                      <br>
                                       <div class="row">
                                           <div class="col-md-12">
                                               <div class="col-md-12">
                                                   <div class="alert alert-warning alert-dismissable">
                                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                  <strong>Atención........</strong> El usuario ya tiene un documento adjunto;
                                                  </div>
                                               </div>
                                           </div>
                                       </div>
                                    <?php }?>
                             <?php }?>
                           <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        Suministro:
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <input type="text" id="suministro"  name="suministro" class="form-control"  value="<?php echo $suministro ?>" style="width:100%;" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        Nombres y Apellidos del Titular de la Conexión<sup>(1)</sup>:
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="nombre" name="dato_apellido" value="<?php echo $nombre ?>" style="width:100%;" readonly >
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-12">
                                    <div class="col-md-12" >
                                         Nro.DNI/C. Ident. / C. Extranj. / RUC:    
                                    </div> 
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $documento ?>" style="width:100%;"  readonly>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                      <?php if($estado_arch=='0'){ ?>
                                        <button  class="btn btn-success btn-block btn-flat" id="ver_doc"  >
                                          IMPRIMIR SOLICITUD
                                        </button>
                                      <?php } else { ?>
                                        <button  class="btn btn-success btn-block btn-flat" id="ver_doc" disabled >
                                          IMPRIMIR SOLICITUD
                                        </button>
                                     <?php } ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if($estado_arch=='0'){ ?>
                                            <span class="btn btn-success btn-block btn-flat btn-file">
                                                ADJUNTAR ARCHIVO <input  type = "file" name = "userfile"  id="subir" required>
                                            </span>        
                                          <?php } else { ?>
                                            <span class="btn btn-success btn-block btn-flat btn-file" disabled>
                                                ADJUNTAR ARCHIVO <input type = "file" name = "userfile" disabled>
                                            </span> 
                                         <?php } ?>
                                        
                                    </div>
                                    <div class="col-md-4 ">
                                        <?php if($estado_arch=='0'){ ?>
                                            <button  type="submit" class="btn btn-success btn-block btn-flat" id="adj_doc"  >
                                               GUARDAR SOLICITUD
                                            </button>        
                                          <?php } else { ?>
                                            <button  type="submit" class="btn btn-success btn-block btn-flat" id="adj_doc" disabled >
                                               GUARDAR SOLICITUD
                                            </button> 
                                         <?php } ?>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-md-12">
                                  <div class="col-md-12">
                                     <center>
                                        DETALLE DE ARCHIVO ADJUNTADO
                                     </center>
                                  </div>
                              </div>
                              <div class="col-md-12" id="detalle">

                                 <div class="col-md-6" >
                                    <h4>ADJUNTAR UN ARCHIVO</h4>
                                 </div>
                              </div>
                            </div>
                           
                            
                            
                            
                        </div>
                     </form>       
                    </div>
                </div>
            </div>
            <br>
    
</section>
<script>
    $( "#ver_doc" ).click(function() {
        //alert("<?php echo $dire_arch; ?>");
        window.open("<?php echo base_url().$dire_arch; ?>","_blank","fullscreen=yes");
    });
   $('#subir').change(function(){
        var fileName = this.files[0].name;
        var fileSize = this.files[0].size;
        var fileType = this.files[0].type;
        if(fileName != "")
        {
          $('#detalle').empty();
          $('#detalle').append("<div class='col-md-12'>NOMBRE : "+fileName+"</div>"+"<div class='col-md-12'>TAMAÑO : "+(fileSize/1024)+" MB</div>"+"<div class='col-md-12'>TIPO : "+fileType+" </div>");
  
        }
        else{
          $('#detalle').empty();
          $('#detalle').append("<div class='col-md-12'>NO SE ADJUNTO NINGUN ARCHIVO</div>");
        }
        //alert('FileName : ' + fileName + '\nFileSize : ' + fileSize + ' bytes');
    });
</script>
