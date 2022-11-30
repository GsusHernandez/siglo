<form role="form" id="formBusqFactura">
<div class="box-body">
<div class="col-md-6">
<div class="form-group">
<label for="exampleInputEmail1">Numero Factura</label>
<input type="text" class="form-control" id="numeroFactura" placeholder="Numero Factura">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="exampleInputPassword1">Fecha Factura</label>
<div class="input-group">
<span class="input-group-addon">
<input type="checkbox" checked id="checkboxFechaFactura" >
</span>
<input readonly="readonly" type="text" class="form-control formFechas" disabled id="fechaFactura" placeholder="Fecha de Factura">
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="exampleInputPassword1">Cliente</label>
<select id="codigoClienteFactura" class="form-control select2" style="width: 100%;">
<option value="0">NINGUNO</option>
<?php 
$consultarClientes=mysql_query("SELECT id,codigo,nombre FROM clientes");
while ($resClientes=mysql_fetch_array($consultarClientes)){
?>
<option value="<?php echo $resClientes["id"];?>"><?php echo $resClientes["nombre"]." (".$resClientes["codigo"].")";?></option>
<?php
}
?>
</select>
</div>
</div>
</div>
<div class="box-footer">
<div class="col-md-6">
<div class="form-group">
<a id="btnSubmitBuscarFactura" class="btn btn-primary">Buscar</a>
<input type="hidden" id="exeFrmBusqFactura">
</div>
</div>
</div>
</form>