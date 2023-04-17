<!-- Vista solo de testeo para añadir usuarios -->
<div class="row bg-light h-100">
    <div class="col-8 m-auto">
        <h1 class="display-3">Vista de Prueba Para añadir usuarios</h1>
        <div class="col-12 d-flex flex-column flex-md-row gap-3">
        <div class="col-12 col-md-4">
            <form action="/usuarios/add" method="post">
            <label for="username">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo isset($input['nombre']) ? $input['nombre'] : '';?>"/>
        </div>
        <div class="col-12 col-md-4">
            <label for="username">Email:</label>
            <input type="text" class="form-control" name="email" id="email" value="<?php echo isset($input['email']) ? $input['email'] : '';?>"/>
        </div>
        <div class="col-12 col-md-4">
            <label for="username">Contraseña:</label>
            <input type="password" class="form-control" name="pass" id="pass" value="<?php echo isset($input['pass']) ? $input['pass'] : '';?>"/>
        </div>
            </div>
        <div class="col-6 mb-2">
            <label for="username">Rol Usuario:</label>
               <select name="rol[]" id="rol" class="form-control select2" data-placeholder="Roles">
                    <option value="">Ninguno</option>
                            <?php
                               foreach ($roles as $rol) {
                              ?>
                      <option value="<?php echo $rol['id_rol']; ?>" <?php echo (isset($input['id_rol']) && $rol['id_rol'] == $input['id_rol']) ? 'selected' : ''; ?>><?php echo $rol['id_rol']." - ".ucfirst($rol['nombre_rol']); ?></option>
                            <?php
                               }
                              ?>
                     </select>
        </div>
     
        
                <div class="card-footer">
                    <div class="col-12 text-right">                     
                        <a href="/" value="" name="reiniciar" class="btn btn-info">Volver</a>
                        <input type="submit" value="Añadir Usuario" class="btn btn-primary ml-2"/>
                    </div>
                </div>
        </form>
    </div>    
</div>