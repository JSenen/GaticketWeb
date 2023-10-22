<!-- LEER DE API -->
<?php
$url = 'http://localhost:8080/users';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$data = json_decode($response, true);
?>
<div>
    <?php if (!empty($data)): ?>
        <h1>Usuarios TIP</h1>
        <ul>
            <?php foreach ($data as $user): ?>
                <li>Nombre de usuario: <?php echo $user['userTip']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No se encontraron usuarios.</p>
    <?php endif; ?>
</div>

<!-- GRABAR EN API -->
<div>
    <h2>Formulario para Agregar un Nuevo Usuario</h2>
    <form method="post" action="grabar_usuario.php"> <!-- Crear un archivo grabar_usuario.php para procesar el POST -->
        <label for="userMail">Correo Electrónico:</label>
        <input type="text" name="userMail" id="userMail" required><br>

        <label for="userPassword">Contraseña:</label>
        <input type="password" name="userPassword" id="userPassword" required><br>

        <label for="userTip">Usuario TIP:</label>
        <input type="text" name="userTip" id="userTip" required><br>

        <input type="submit" value="Grabar Usuario">
    </form>
</div>

