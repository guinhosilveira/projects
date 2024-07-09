<?php

require_once 'connection.php';

$connection = new Connection();

$users = $connection->query("SELECT * FROM users");

if ($_REQUEST) {
    $user = $_REQUEST['bt_excluir'];

    $result = $connection->query("DELETE FROM users WHERE id=" . $user . "");
    $result = $connection->query("DELETE FROM user_color WHERE user_id=" . $user . "");

    header('Location: index.php');  
}

require './header.php';

echo "<h1>Mostrar Usuários</h1>

    <table border='1'>

            <tr>

                <th>ID</th>    
                <th>Nome</th>    
                <th>Email</th>
                <th>Ação</th>  

            </tr>
            ";

foreach ($users as $user) {

    echo sprintf(
        "<tr>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>
                    <form action='' method='post'>
                    <button type='submit' name='bt_editar' value='%s' formaction='user.php'>Editar</button>
                    <button type='submit' name='bt_excluir' value='%s'>Excluir</button>
                    </form>
                    </td>
                </tr>",
        $user->id,
        $user->name,
        $user->email, 
        $user->id,
        $user->id
    );
}

echo "</table>";

?>

<a href="form.php">
    <button>
        Novo Usuário
    </button>
</a>

</div>

</body>

</html>