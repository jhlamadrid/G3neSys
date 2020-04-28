<section class="content">
  <form id="formulario" data-toggle="validator" name="formularioUsuario" role="form" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-body with-border">
            <h4 style="font-family:'Ubuntu';font-weight:bold">DATOS DE LA NOTA CRÉDITO <?php echo $nota['BFNCATLET'].$nota['BFNCASERNRO']."-".$nota['BFNCANRO'] ?> <span class="pull-right" style="font-size:12px"><b>FECHA EMISIÓN: <?php echo $nota['BFNCAFECHEMI']." ".$nota['BFNCAHRAEMI']?></b></span></h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="input-group" style="margin-top:5px">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger" style="width:100px">CLIENTE</button>
                  </div>
                  <input type="text" class="form-control" id="cliente" value="<?php echo $nota['FSCCLINOMB']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="input-group" style="margin-top:5px">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger" style="width:100px">SERIE</button>
                  </div>
                  <input type="text" class="form-control" id="serie" value="<?php echo $nota['BFNCATLET'].$nota['BFNCASERNRO']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="input-group" style="margin-top:5px">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger" style="width:100px">NUMERO</button>
                  </div>
                  <input type="text" class="form-control" id="numero" value="<?php echo $nota['BFNCANRO']; ?>" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 cols-m-3">
                <div class="input-group" style="margin-top:5px">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger" style="width:100px"><?php echo (($nota['FSCCLIRUC']) ? "RUC" : "DNI") ?></button>
                  </div>
                  <input type="text" class="form-control" id="numero" value="<?php echo ( ($nota['FSCCLIRUC']) ? $nota['FSCCLIRUC'] : $nota['FSCNRODOC'])  ?>" disabled>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="input-group" style="margin-top:5px">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger" style="width:100px">SUBTOTAL</button>
                  </div>
                  <input type="text" class="form-control" id="subtotal" value="<?php echo number_format($nota['BFNCASUBDIF'],2,'.','')  ?>" disabled>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="input-group" style="margin-top:5px">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger" style="width:100px">I.G.V.</button>
                  </div>
                  <input type="text" class="form-control" id="igv" value="<?php echo number_format($nota['BFNCAIGVDIF'],2,'.','')  ?>" disabled>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="input-group" style="margin-top:5px">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger" style="width:100px">TOTAL</button>
                  </div>
                  <input type="text" class="form-control" id="total" value="<?php echo number_format($nota['BFNCATOTDIF'],2,'.','')  ?>" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-body with-border">
            <h4 style="font-family:'Ubuntu'">DETALLE</h4>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="detalle_nota" class="table table-bordered table-striped">
                <thead>
                  <tr role='row'>
                    <th>ITEM</th>
                    <th>CONCEPTO</th>
                    <th>DESRIPCIÓN</th>
                    <th>DESCUENTO</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; foreach ($detalle as $det ) { ?>
                  <tr>
                    <td><?php echo $i; $i++;?></td>
                    <td><?php echo $det['CONCEP_FACCONCOD'] ?></td>
                    <td><?php echo $det['FACCONDES'] ?></td>
                    <td style="text-align:right"><?php echo number_format($det['NCAPREDIF'],2,'.','')?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-md-3 col-sm-3">
                <?php echo (isset($btn_comprobante) ? $btn_comprobante : "") ?>
              </div>
              <div class="col-md-6 col-sm-6">

              </div>
              <div class="col-md-3 col-sm-3">
                <?php echo (isset($btn_pagar) ? $btn_pagar : "") ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>
