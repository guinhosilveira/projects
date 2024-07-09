<?php 

require_once 'connection.php';

$connection = new Connection();

require './header.php';

if ($_REQUEST) {
    
    $nome  = $_REQUEST['nome'];
    $email = $_REQUEST['email'];
    $color = $_REQUEST['color'];

    if ($color!=0) {
        
    }

    $result = $connection->query("INSERT INTO users (name, email) VALUES ('" . $nome . "','" . $email . "')");

    header('Location: index.php');  
}

?>

    <form class="form-users" action="" method="post">

        <h1>
            Cadastrar Usuário
        </h1>

        <div class="input-wrapper">

            <label for="event-name">
                Nome:
            </label>
            <input 
                type="text" 
                name="nome"
                placeholder="nome e sobrenome" 
                id="event-name" 
                required />

        </div>
        
        <div class="input-wrapper">

            <label for="event-email">
                Email:
            </label>
            <input 
                type="email" 
                name="email" 
                placeholder="exemplo@email.com"
                id="event-email" 
                required />

        </div>
        
        <button type="submit">Enviar</button>

    </form>

</div>