<?php
$consultarInformacionUsuario=mysql_query("SELECT * FROM usuarios WHERE id='".$idUsuario."'");
$resInformacionUsuario=mysql_fetch_array($consultarInformacionUsuario);

?>
<div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"></h4>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label>Usuario</label>
                                                    <input type="text" class="form-control" disabled="" placeholder="Usuario" value="<?php echo $resInformacionUsuario["usuario"];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <label>NOMBRES</label>
                                                    <input type="text" class="form-control" placeholder="Nombres" value="<?php echo $resInformacionUsuario["nombre"];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">APELLIDOS</label>
                                                    <input type="text" class="form-control" placeholder="Apellidos" value="<?php echo $resInformacionUsuario["apellido"];?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 pr-1">
                                                <div class="form-group">
                                                    <label>CORREO</label>
                                                    <input type="text" class="form-control" placeholder="CORREO" value="<?php echo $resInformacionUsuario["correo"];?>">
                                                </div>
                                            </div>
                                            <?php
                                            $consultarTipoUsuario=mysql_query("SELECT * FROM definicion_tipos WHERE id_tipo=28");
                                            ?>
                                            <div class="col-md-3 pr-1">
                                                <div class="form-group">
                                                    <label>TIPO DE USUARIO</label>
                                                    <select name="ips" id="ips" class="form-control " style="width: 100%;">

                                            <?php
                                            while ($resTipoUsuario=mysql_fetch_array($consultarTipoUsuario)){
                                                if ($resTipoUsuario["id"]==$resInformacionUsuario["tipo_usuario"])
                                                {
                                                    ?>
                                                     <option selected value="<?php echo $resTipoUsuario["id"];?>"><?php echo $resTipoUsuario["descripcion"];?></option>
                                                    <?php
                                                }else{
                                                       ?>
                                                     <option  value="<?php echo $resTipoUsuario["id"];?>"><?php echo $resTipoUsuario["descripcion"];?></option>
                                                    <?php
                                                }
                                              
                                            }
                                            ?>
                                            
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        
                                     
                                        <div class="row">
                                           <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>CONTRASEÑA</label>
                                                    <input type="text" class="form-control" placeholder="CONTRASEÑA">
                                                </div>
                                            </div>

                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>CONFIRMAR CONTRASEÑA</label>
                                                    <input type="text" class="form-control" placeholder="CONFIRMAR CONTRASEÑA">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-info btn-fill pull-right">Actualizar Usuario</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                   
                </div>