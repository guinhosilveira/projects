<?php

require_once 'connection.php';
session_start();

$connection = new Connection();
$colors     = $connection->query("SELECT * FROM colors");

require 'header.php';

if (isset($_REQUEST['bt_editar'])) {

    $_SESSION['id'] = $_REQUEST['bt_editar'];
    $select         = $connection->query("SELECT * FROM users WHERE id = " . $_SESSION['id'] . "");
    $user           = $select->fetch(PDO::FETCH_ASSOC);
    
}

$select         = $connection->query("SELECT * FROM user_colors WHERE user_id = " . $_SESSION['id']);
$user_colors    = $select->fetchall(PDO::FETCH_DEFAULT);

if (isset($_REQUEST['bt_update'])) {

    $name   = $_REQUEST['nome'];
    $email  = $_REQUEST['email'];
    $update = $connection->query("UPDATE users SET name = '" . $name . "', email = '" . $email . "' WHERE id = " . $_SESSION['id'] );
    
    if (isset($_REQUEST['ck_colors'])) {
        $color = $_REQUEST['ck_colors'];
        $old_colors = array_column($user_colors, 'color_id');
        $inserted_colors = array_values(
            array_diff($color, $old_colors)
        );
        $deleted_colors = array_values(
            array_diff($old_colors, $color)
        );
        
        foreach ($inserted_colors as $key => $value) {
            
            $query = "INSERT INTO user_colors (color_id, user_id) VALUES (" . $value . ", " . $_SESSION['id'] . ")";
            echo $query;
            $insert = $connection->query($query);
            
        }

        foreach ($deleted_colors as $key => $value) {
            
            $delete = $connection->query("DELETE FROM user_colors WHERE color_id = " . $value . " AND user_id = " . $_SESSION['id']);
            
        }

    }

    header('Location: index.php');

}

?>

<form action="" method="post">

    <h1>
        Editar Usuário
    </h1>

    <div class="input-wrapper">

        <label for="event-name">
            Informe seu nome:
        </label>
        <input 
            type="text" 
            name="nome" 
            placeholder="nome e sobrenome" 
            value="<?=$user['name']?>"
            id="event-name" 
            required />

    </div>

    <div class="input-wrapper">

        <label for="event-email">
            Informe seu email:
        </label>
        <input 
            type="email" 
            name="email" 
            placeholder="exemplo@email.com" 
            value="<?=$user['email']?>"
            id="event-email" 
            required />

    </div>

    <label for="event-color" class="lbl_color">
        Vincule ou Desvinculve as Cores ao Usuário:
    </label>

        <div class="checkbox-wrapper">

    <?php

    foreach ($colors as $key => $value) {

        $checked = "";

        if (is_array($user_colors) && !empty($user_colors) && in_array($value->id, array_column($user_colors, 'color_id'))) {
            $checked = "checked";
        }

            echo "<div class='item'>";
            echo sprintf("<input type='checkbox' name='ck_colors[]' value='%s' %s>%s", $value->id, $checked, $value->name);
            echo "</div>";       
   
    }

    ?>
    </select>

    </div>

    <button type="submit" name="bt_update">Enviar</button>
</form>